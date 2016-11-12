<?php
/**
 * 销售控制器
 */
class SalesController extends Controller {
	
	/**
	 * 流水列表
	 * @return [void]
	 */
	public function index() {
		$this->set('title','流水 - 库存管理系统');
		$curPage = _get('page');
		$startTime = _get('startTime') ? strtotime(date('Y-m-d', strtotime(_get('startTime')))) : strtotime(date('Y-m-d'));
		$endTime = _get('startTime') ? strtotime(date('Y-m-d 23:59:59', strtotime(_get('startTime')))) : strtotime(date('Y-m-d 23:59:59'));
		$data = $this->Sale->getPageList('add_time between ' . $startTime . ' and ' . $endTime, $curPage,1);
		if (count($data) < 1) {
			$page = '';
		} else {
			$page = $this->page($curPage, $_SESSION['sales']['total']);
		}
		$this->set('page', $page);
		$this->set('data', $data);
		$this->template();
	}

	/**
	 * 出库列表
	 * @return [void]
	 */
	public function delivering() {
		$this->set('title', '出库 - 库存管理系统');
		$error_info = '';
		if ($this->isPost()) {
			$stocksId = _post('stocksId');
			$barcode = _post('barcode');
			if ($stocksId || $barcode) {
				// 根据库存编码或条形码获取数据信息
				$stocksInfo = $this->Sale->getStocksInfo($stocksId, $barcode);
				if ($stocksInfo) {
					// 计算销售数量 
					if ($_SESSION['sale_info'][$stocksInfo['Stock']['id']]) {
						$number = $_SESSION['sale_info'][$stocksInfo['Stock']['id']]['amount'] + 1;
					} else {
						$number = 1;
					}
					// 检查库存数
					if ($number > $stocksInfo['Stock']['amount']) {
						$error_info = '库存不足！现余库存数 ' . $stocksInfo['Stock']['amount'];
					} else {
						$_SESSION['sale_info'][$stocksInfo['Stock']['id']] = [
							'goods_num' => $stocksInfo['Stock']['goods_num'],
							'bar_code' => $stocksInfo['Stock']['bar_code'],
							'amount' => $number,
							'add_time' => time()
						];
					}
				} else {
					$error_info = '库存不足！';
				}
				
			} else { 
				$error_info = '请输入库存编码或条形码！';
			}
		}
		$this->set('errorInfo', $error_info);
		$this->set('saleInfo', getSession('sale_info'));
		$this->template();
	}
	
	/**
	 * 待出库数据删除
	 * @param  [int]  $id
	 * @return [void]
	 */
	public function del($id) {
		if ($_SESSION['sale_info'][$id]) {
			$_SESSION['sale_info'][$id]['number'] -= 1;
			if ($_SESSION['sale_info'][$id]['number'] < 1) {
				unset($_SESSION['sale_info'][$id]);
			}
		} else {
			unset($_SESSION['sale_info'][$id]);
		}
		$this->jump('/sales/delivering');
	}

	/**
	 * 批量出库
	 * @return [void]
	 */
	public function add() {
		$this->Sale->doSale();
		unset($_SESSION['sale_info']);
		$this->jump('/sales/index');
	}

}