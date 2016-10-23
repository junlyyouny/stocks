<?php

/**
 * 数据库操作基类
 */
class SQLQuery {

	protected $_dbHandle;
	protected $_result;

	/**
	 * 连接数据库
	 * @param  [str] $address [连接地址]
	 * @param  [str] $account [账号]
	 * @param  [str] $pwd     [密码]
	 * @param  [str] $name    [数据库名]
	 * @return [bool]
	 */
	function connect($address, $account, $pwd, $name) {
		$this->_dbHandle = new mysqli($address, $account, $pwd);
		if ($this->_dbHandle->connect_errno) {
			return false;
		} else {
			if ($this->_dbHandle->select_db($name)) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * 中断数据库连接
	 * @return [bool]
	 */
	function disconnect() {
		return $this->_dbHandle->close();
	}

	/**
	 * 查询所有数据表内容
	 * @return [arr]
	 */
	function selectAll() {
		$query = 'select * from `'.$this->_table.'`';
		return $this->query($query);
	}

	/** 
	 * 查询数据表指定列内容
	 * @param  [int] $id
	 * @return [arr]
	 */
	function select($id = 0, $field = '*') {
		$query = 'select ' . $field . ' from `'.$this->_table.'` where `id` = \''.$this->_dbHandle->real_escape_string($id).'\'';
		return $this->query($query, 1);
	}

	/**
	 * 自定义SQL查询语句
	 * @param  [str]  $query
	 * @param  integer $singleResult [只取一条]
	 * @return [arr]
	 */
	function query($query, $singleResult = 0) {
		$this->_result = $this->_dbHandle->query($query);
		if (preg_match("/select/i",$query)) {
			$result = array();
			$table = array();
			$field = array();
			$tempResults = array();
			$numOfFields = $this->_result->field_count;
			$fetchFields = $this->_result->fetch_fields();
			for ($i = 0; $i < $numOfFields; ++$i) {
				array_push($table, $fetchFields[$i]->table);
				array_push($field, $fetchFields[$i]->name);
			}
			while ($row = $this->_result->fetch_row()) {
				for ($i = 0;$i < $numOfFields; ++$i) {
					$table[$i] = trim(ucfirst($table[$i]),'s');
					$tempResults[$table[$i]][$field[$i]] = $row[$i];
				}
				if ($singleResult == 1) {
					$this->freeResult();
					return $tempResults;
				}
				array_push($result, $tempResults);
			}
			$this->freeResult();
			return $result;
		}
	}

	/**
	 * 返回结果集行数
	 * @return [int]
	 */
	function getNumRows() {
		return $this->_result->num_rows;
	}

	/**
	 * 释放结果集内存
	 * @return [bool]
	 */
	function freeResult() {
		$this->_result->free();
		return $this->disconnect();
	}

	/**
	 * 返回MySQL操作错误信息
	 * @return [str]
	 */
	function getError() {
		return $this->_dbHandle->error;
	}
}
