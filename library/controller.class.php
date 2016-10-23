<?php

/**
 * 控制器基类
 */
class Controller {
	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_template;

	function __construct($model, $controller, $action) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_model = $model;
		$this->$model = new $model;
		$this->_template = new Template($controller,$action);
	}

	public function set($name,$value) {
		$this->_template->set($name,$value);
	}

	public function template($name = '') {
		$this->_template->render($name);
	}

	function __destruct() {
		
	}

	public function jump($url) {
		echo '<script language="Javascript">';
		echo 'window.location.href="'.$url.'"';
		echo '</script>';
		exit;
	}

	public function isPost() {
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
}