<?php
/**
 * 示例模型
 */
class Item extends Model {

	function __construct() {
		var_dump($this->_model);exit;
		$this->_model = 'stocks';
	}

	public function changeTable($table_name) {
		return $this->_table = $table_name;
	}
}