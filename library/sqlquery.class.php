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
	public function connect($address, $account, $pwd, $name) {
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
	public function disconnect() {
		return $this->_dbHandle->close();
	}

	/**
	 * 查询所有数据表内容
	 * @return [arr]
	 */
	public function selectAll() {
		$query = 'select * from `'.$this->_table.'`';
		return $this->query($query);
	}

	/**
	 * 根据条件查询数据表内容
	 * @param  [str]  $where
	 * @param  [str]  $field
	 * @param  integer $singleResult [只取一条]
	 * @return [arr]
	 */
	public function selectByWhere($where = 1, $field = '*') {
		$query = 'select ' . $field . ' from `'.$this->_table.'` where ' . $where;
		return $this->query($query);
	}

	/** 
	 * 查询数据表指定列内容
	 * @param  [int] $id
	 * @return [arr]
	 */
	public function select($id = 0, $field = '*') {
		$query = 'select ' . $field . ' from `'.$this->_table.'` where `id` = \''.$this->_dbHandle->real_escape_string($id).'\'';
		return $this->query($query, 1);
	}

	/** 
	 * 删除数据表指定列
	 * @param  [int] $id
	 * @return [arr]
	 */
	public function delete($id = 0) {
		$query = 'DELETE FROM `'.$this->_table.'` WHERE `id` = \''.$this->_dbHandle->real_escape_string($id).'\'';
		return $this->query($query, 1);
	}

	/** 
	 * 查询数据表指定列内容
	 * @param  [str] $barCode
	 * @param  [str]  $field
	 * @return [arr]
	 */
	public function selectByBarCode($barCode = 0, $field = '*') {
		$query = 'select ' . $field . ' from `'.$this->_table.'` where `bar_code` = \''.$this->_dbHandle->real_escape_string($barCode).'\'';
		return $this->query($query, 1);
	}

	/**
	 * 自定义SQL查询语句
	 * @param  [str]  $query
	 * @param  [integer] $singleResult [只取一条]
	 * @return [arr]
	 */
	public function query($query, $singleResult = 0) {
		$this->_result = $this->_dbHandle->query($query);
		if ($this->_result && preg_match("/select/i",$query)) {
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
					$table[$i] = rtrim(ucfirst($table[$i]),'s');
					// 当table名为空时用$i替换
					if (!$table[$i]) {
						$table[$i] = $i;
					}
					$tempResults[$table[$i]][$field[$i]] = $row[$i];
				}
				if ($singleResult == 1) {
					return $tempResults;
				}
				array_push($result, $tempResults);
			}
			return $result;
		}
		return false;
	}

	/**
	 * 返回结果集行数
	 * @return [int]
	 */
	public function getNumRows() {
		return $this->_result->num_rows;
	}

	/**
	 * 释放结果集内存
	 * @return [bool]
	 */
	public function freeResult() {
		$this->_result->free();
		return $this->disconnect();
	}

	/**
	 * 返回MySQL操作错误信息
	 * @return [str]
	 */
	public function getError() {
		return $this->_dbHandle->error;
	}

	/**
	 * 批量插入数据
	 * @param  [array]  $data
	 * @return [bool]
	 */
	public function insert($data = []) {
		if (empty($data)) {
			return false;
		}
		$data = array_values($data);
		$query = 'INSERT INTO `' . $this->_table . '`';
		$fields = implode(',', array_keys($data[0]));
		$query .= '(' .$fields . ') VALUES ';
		foreach ($data as $value) {
			$values = implode(',', array_values($value));
			$query .= ' ('. $values . '),';
		}
		$query = rtrim($query, ',');
		$query .= ';';
		return $this->query($query);
	}

	/**
	 * 批量update数据
	 * @param  [array]  $data
	 * @return [bool]
	 */
	public function update($data = []) {
		if (empty($data)) {
			return false;
		}
		$query = 'UPDATE `' . $this->_table . '` SET ';
		$ids = implode(',', array_keys($data));
		$fields = [];
		foreach ($data as $id => $info) {
			foreach ($info as $field => $value) {
				$fields[$field][$id] = $value;
			}
		}
		foreach ($fields as $field => $value) {
			$query .= ' `' . $field . '` = CASE `id`';
			foreach ($value as $id => $value) {
				$query .= ' WHEN ' . $id . ' THEN ' . $value;
			}
			$query .= ' END,';
		}
		$query = rtrim($query, ',');
		$query .= ' WHERE id IN (' . $ids . ');';
		return $this->query($query);
	}
	
	/**
	 * 分页查询
	 * @param  [str]  $where
	 * @param  [int]  $rows 每页个数
	 * @param  [str]  $field
	 * @return [void]
	 */
	public function pageList($where = 1, $rows = 10, $field = '*') {
		$info = $this->query('SELECT SQL_CALC_FOUND_ROWS ' . $field . ' from `'.$this->_table . '` where ' . $where . ' limit ' . $rows);
		$total = $this->query('SELECT FOUND_ROWS() as total ', 1);
		// 记录查询数据的总页数
		$_SESSION[$this->_table]['total'] = ceil($total[0]['total'] / $rows);
		return $info;
	}
}
