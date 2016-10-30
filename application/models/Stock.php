<?php
/**
 * 库存模型
 */
class Stock extends Model {
	
	/**
	 * 批量入库
	 * @return [bool]
	 */
	public function insertDatas() {
		$storage_info = getSession('storage_info');
		if ($storage_info) {
			// 整理数组
			$sort_arr = [];
			foreach ($storage_info as $info) {
				$sort_arr[$info['goodsNum']]['goods_num'] = $info['goodsNum'];
				$sort_arr[$info['goodsNum']]['barcode'][] = $info['barcode'];
				$sort_arr[$info['goodsNum']][$info['barcode']][] = $info['barcode'];
				
			}
			// 构造入库数据
			$data = [];
			foreach ($sort_arr as $goods) {
				$bar_arr = array_unique($goods['barcode']);
				foreach ($bar_arr as $barcode) {
					$data[] = [
						'goods_num' => $goods['goods_num'],
						'bar_code' => $barcode,
						'amount' => count($sort_arr[$goods['goods_num']][$barcode]),
						'add_time' => time()
					];
				}
				
			}
		}
		print_r($data);exit;
		// 检测数据是否存在，存在则调整库存，不存在则新增
		return $this->insert();
	}
}
