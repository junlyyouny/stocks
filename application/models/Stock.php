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
				// 删除处理后多余的数据
				unset($data[$key]);
			}
		}
		// 新增数组不为空则批量插入
		if ($data) {
			$do_insert = $this->insert($data);
		}
		// 更新数组不为空则批量更新
		if ($up_data) {
			$do_update = $this->update($up_data);
		}
		return true;
	}
	
	/**
	 * 根据商品编码或条形码获取数据信息
	 * @param  [str]  $goodsNum 商品编码
	 * @param  [str]  $barcode 条形码
	 * @return [array]
	 */
	public function getStocksInfo($goodsNum = '', $barcode = '') {
		if ($goodsNum) {
			$stocksInfo = $this->selectByWhere('goods_num = ' . $goodsNum);
		} elseif ($barcode) {
			// 条形码查询为单条查询，需与多条查询结果保持一致
			$stocksInfo[0] = $this->selectByBarCode($barcode);
		} else {
			$stocksInfo = [];
		}
		return $stocksInfo;
	}

}
