<?php
/**
 * 库存控制器
 */
class StocksController extends Controller {

	/**
	 * 库存列表
	 * @return [void]
	 */
	function stock() {
		$this->set('title', '库存 - 库存管理系统');
		// echo $this->_action;exit;
		$this->template();
	}

	/**
	 * 入库列表
	 * @return [void]
	 */
	function storage() {
		$this->set('title', '入库 - 库存管理系统');
		$this->template();
	}

	/**
	 * 出库列表
	 * @return [void]
	 */
	function delivering() {
		$this->set('title', '出库 - 库存管理系统');
		$this->template();
	}

	function add() {
		$todo = $_POST['todo'];
		$this->set('todo',$this->Item->query('insert into items (item_name) values (\''.mysql_real_escape_string($todo).'\')'));
		$this->template();
	}

	function delete($id) {
		$this->set('todo',$this->Item->query('delete from items where id = \''.mysql_real_escape_string($id).'\''));
		$this->template();
	}
}