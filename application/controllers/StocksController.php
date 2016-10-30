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
		$goodsNum = _post('goodsNum');
		if ($this->isPost() && $goodsNum) {
			$barcode = _post('barcode');
			$_SESSION['storage_info'][] = [
				'goodsNum' => $goodsNum,
				'barcode' => $barcode,
				'addTime' => date('Y-m-d H:i:s'),
			];
		}
		$this->set('goodsNum', $goodsNum);
		$this->set('storageInfo', getSession('storage_info'));
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
	
	/**
	 * 批量入库
	 * @param  [int]  $id
	 * @return [void]
	 */
	public function add() {
		
		$res = $this->Stock->insertDatas();
		print_r($res);
	}

	/**
	 * 删除单条数据
	 * @param  [int]  $id
	 * @return [void]
	 */
	public function delete($id) {
		$this->set('todo',$this->Item->query('delete from items where id = \''.mysql_real_escape_string($id).'\''));
		$this->template();
	}
	
	/**
	 * 待入库数据删除
	 * @param  [int]  $id
	 * @return [void]
	 */
	public function del($id) {
		unset($_SESSION['storage_info'][$id]);
		$this->jump('/stocks/storage');
	}
}
