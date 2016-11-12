<?php
/**
 * 首页
 */
class IndexsController extends Controller {
	
	/**
	 * 首页
	 * @return [void]
	 */
	public function index() {
		$this->set('title','首页');
		$this->template();
	}

	/**
	 * 框架示例页
	 * @return [void]
	 */
	public function home() {
		$this->set('title','My Frame App');
		$this->template();
	}

}