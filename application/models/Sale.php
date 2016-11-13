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
}