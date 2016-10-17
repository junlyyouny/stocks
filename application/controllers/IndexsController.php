<?php
/**
 * 首页
 */
class IndexsController extends Controller {
	
	function index() {
		$this->set('title','首页');
		$this->template();
	}

	function home() {
		$this->set('title','My Frame App');
		$this->template();
	}

}