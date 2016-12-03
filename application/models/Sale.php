<?php
/**
 * 销售模型
 */
class Sale extends Model {

	/**
	 * 根据库存编码或条形码获取数据信息
	 * @param  [int]  $stocksId 库存id
	 * @param  [str]  $barcode 条形码
	 * @return [array]
	 */
	public function getStocksInfo($stocksId = 0, $barcode = '') {
		$obj_Stock = new Stock;
		if ($stocksId) {
			$stocksInfo = $obj_Stock->select($stocksId);
		} elseif ($barcode) {
			$stocksInfo = $obj_Stock->selectByBarCode($barcode);
		} else {
			$stocksInfo = [];
		}
		return $stocksInfo;
	}

	/**
	 * 记录出库信息
	 * @return [bool]
	 */
	public function doSale() {
		$sale_info = getSession('sale_info');
		// 记录销售流水
		$do_insert = $this->insert($sale_info);
		if ($do_insert = 1) {
			$obj_Stock = new Stock;
			// 获取待出库数据
			$stocksIds = implode(',', array_keys($sale_info));
			$stocksInfo = $obj_Stock->selectByWhere('id in (' . $stocksIds . ')');
			// 构造出库数据
			$up_data = [];
			foreach ($stocksInfo as $key => $value) {
				$number = $value['Stock']['amount'] - $sale_info[$value['Stock']['id']]['amount'];
				$number = $number > 0 ? $number : 0;
				$up_data[$value['Stock']['id']] = [
					'amount' => $number,
				];
			}
			// 更新库存
			return $obj_Stock->update($up_data);
		} else {
			return false;
		}
	}

	/**
	 * 进行退货操作
	 * @param  [int]  $id 流水号
	 * @return [bool]
	 */
	public function refunds($id = 0) {
		// 获取流水信息
		$saleInfo = $this->select($id);
		if ($saleInfo) {
			$upStock = false;
			if ($saleInfo['Sale']['amount']) {
				// 还原库存
				$obj_Stock = new Stock;
				$stocksInfo = $obj_Stock->selectByBarCode($saleInfo['Sale']['bar_code']);
				if ($stocksInfo) {
					$up_data[$stocksInfo['Stock']['id']] = [
						'amount' => $stocksInfo['Stock']['amount'] + $saleInfo['Sale']['amount'],
					];
					$upStock = $obj_Stock->update($up_data);
				}
			}
			// 更新流水信息
			if ($upStock) {
				$up_sale[$id] = [
					'amount' => 0,
				];
				return $this->update($up_sale);
			}
		}
		return false;
	}
}