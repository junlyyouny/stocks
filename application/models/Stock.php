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
		$up_data = [];
		// 检测数据是否存在
		$goods_bar = array_column($data, 'bar_code');
		foreach ($goods_bar as $key => $barCode) {
			$hade_info = $this->selectByBarCode($barCode);
			if ($hade_info) {
				$up_data[$hade_info['Stock']['id']] = [
					'amount' => $hade_info['Stock']['amount'] + $data[$key]['amount'],
					'add_time' => time()
				];
				// unset $data info
				unset($data[$key]);
			}
		}
		// isset $data do insert
		if ($data) {
			$do_insert = $this->insert($data);
		}
		// isset $up_data do update
		if ($up_data) {
			$do_update = $this->update($up_data);
		}
		return true;
	}
}
