<?php
/**
 * 库存控制器
 */
class StocksController extends Controller {

	/**
	 * 库存列表
	 * @return [void]
	 */
	public function stock() {
		$this->set('title', '库存 - 库存管理系统');
		$this->template();
	}

	/**
	 * 入库列表
	 * @return [void]
	 */
	public function storage() {
		$this->set('title', '入库 - 库存管理系统');
		if ($this->isPost()) {
			$_SESSION['storage_info'][] = [
				'goodsNum' => _post('goodsNum'),
				'barcode' => _post('barcode'),
				'addTime' => date('Y-m-d H:i:s'),
			];
			var_dump($_SESSION);
		}
		$this->template();
	}

	/**
	 * 出库列表
	 * @return [void]
	 */
	public function delivering() {
		$this->set('title', '出库 - 库存管理系统');
		$this->template();
	}

	public function add() {
		// $res = $this->Stock->query('insert into stocks (goods_num,bar_code,amount,add_time) values (236,23655,1,'.time().')');
		// $res = $this->Stock->selectAll();
		$res = $this->Stock->select(2);
		print_r($res);
		// $todo = $_POST['todo'];
		// $this->set('todo',$this->Item->query('insert into items (item_name) values (\''.mysql_real_escape_string($todo).'\')'));
		// $this->template();
	}

	public function delete($id) {
		$this->set('todo',$this->Item->query('delete from items where id = \''.mysql_real_escape_string($id).'\''));
		$this->template();
	}
}
