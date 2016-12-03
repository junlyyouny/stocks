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
		$curPage = _get('page', 1);
		$error_info = '';
		$page = '';
		if ($this->isPost()) {
			// 接收查询参数
			$goodsNum = _post('goodsNum');
			$barcode = _post('barcode');
			if ($goodsNum || $barcode) {
				// 根据条件查询库存
				$data = $this->Stock->getStocksInfo($goodsNum, $barcode);
				if (empty($data)) {
					$error_info = '没有库存信息！';
				}
			} else {
				$error_info = '请输入库存编码或条形码！';
			}
		} else {
			// 非筛选状态下默认展示全部
			$data = $this->Stock->getPageList('amount > 0 order by id desc', $curPage);
			if ($_SESSION['stocks']['total'] > 1) {
				$page = $this->page($curPage, $_SESSION['stocks']['total']);
			}
			if (empty($data)) {
				$error_info = '没有库存信息！';
			}
		}
		$this->set('errorInfo', $error_info);
		$this->set('page', $page);
		$this->set('data', $data);
		$this->template();
	}

	/**
	 * 添加待入库信息
	 * @return [void]
	 */
	public function addStorageInfo() {
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
		if ($error_info) {
			$this->set('title', '入库 - 库存管理系统');
			$this->set('errorInfo', $error_info);
			$this->set('goodsNum', $goodsNum);
			$this->set('storageInfo', getSession('storage_info'));
			$this->template('stocks/storage');
		} else {
			$this->jump('/stocks/storage/' . $goodsNum);
		}
	}

	/**
	 * 入库列表
	 * @return [void]
	 */
	public function storage($goodsNum = '') {
		$this->set('title', '入库 - 库存管理系统');
		$error_info = '';
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
