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
		$curPage = _get('page');
		$data = $this->Stock->getPageList('amount > 0 order by id desc', $curPage);
		if (count($data) < 10) {
			$page = '';
		} else {
			$page = $this->page($curPage, $_SESSION['stocks']['total']);
		}
		$this->set('page', $page);
		$this->set('data', $data);
		$this->template();
	}

	/**
	 * 入库列表
	 * @return [void]
	 */
	public function storage() {
		$this->set('title', '入库 - 库存管理系统');
		$error_info = '';
		$goodsNum = _post('goodsNum');
		if ($this->isPost() && $goodsNum) {
			$barcode = _post('barcode');
			if ($goodsNum && $barcode) {
				$_SESSION['storage_info'][] = [
					'goodsNum' => $goodsNum,
					'barcode' => $barcode,
					'addTime' => date('Y-m-d H:i:s'),
				];
			} else {
				$error_info = '请输入商品编码和条形码！';
			}
		}
		$this->set('errorInfo', $error_info);
		$this->set('goodsNum', $goodsNum);
		$this->set('storageInfo', getSession('storage_info'));
		$this->template();
	}
	
	/**
	 * 批量入库
	 * @return [void]
	 */
	public function add() {
		$this->Stock->insertDatas();
		unset($_SESSION['storage_info']);
		$this->jump('/stocks/stock');
	}

	/**
	 * 删除单条数据
	 * @param  [int]  $id
	 * @return [void]
	 */
	public function delete($id) {
		$this->Stock->delete($id);
		$this->jump('/stocks/stock');
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
