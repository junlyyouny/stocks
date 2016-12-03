<?php

/**
 * 模型基类
 */
class Model extends SQLQuery{
	
	protected $_model;

	public function __construct() {
		$this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$this->_model = get_class($this);
		$this->_table = strtolower($this->_model) . 's';
	}

	public function __destruct() {
		
	}

	/**
	 * 分页查询 
	 * @param  [str]  $where
	 * @param  [int]  $curNum 当前页数
	 * @param  [int]  $rows 每页个数
	 * @return [void]
	 */
	public function getPageList($where = 1, $curNum = 1, $rows = 10) {
		$curNum = $curNum < 1 ? 1 : $curNum;
		// 根据当前页数构造查询条件
		if ($curNum > 1) {
			$start_num = $curNum * $rows - 1;
			$start_num = $start_num > 1 ? $start_num : 1;
			$where .= ' limit ' . $start_num . ',' . $rows;
			// 普通条件查询
			$info = $this->selectByWhere($where);
		} else {
			// 调用分页查询方法
			$info = $this->pageList($where, $rows);
		}
		return $info;
	}
}