<?php

/**
 * 控制器基类
 */
class Controller {
	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_template;

	public function __construct($model, $controller, $action) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_model = $model;
		$this->$model = new $model;
		$this->_template = new Template($controller,$action);
	}

	/**
	 * 设定模板变量
	 * @return [void]
	 */
	public function set($name,$value) {
		$this->_template->set($name,$value);
	}
	
	/**
	 * 加载模板
	 * @return [void]
	 */
	public function template($name = '') {
		$this->_template->render($name);
	}

	public function __destruct() {
		
	}

	/**
	 * 控制器跳转
	 * @return [void]
	 */
	public function jump($url = '') {
		echo '<script language="Javascript">';
		echo 'window.location.href="'.$url.'"';
		echo '</script>';
		exit;
	}

	/**
	 * 显示信息
	 * @param  $msg  弹窗口提示信息(为空没有提示)
 	 * @param  $type 设置类型 close ，back , refresh ，jump
 	 * @param  $url  跳转url
	 * @return [void]
	 */
	public function showMsg($msg = '', $type = '', $url = '') {
		$js = '<script language="Javascript">';
		if ($msg) {
			$js .= 'alert("' . $msg . '");';
		}
	    switch ($type) {
	        case 'close' : 
	            $js .= 'window.close();';
	            break;
	        case 'back' : 
	            $js .= 'history.back(-1);';
	            break;
	        case 'refresh' : 
	            $js .= 'parent.location.reload();';
	            break;
	        case 'top' : 
	            if ($url) {
	                $js .= 'top.location.href="' . $url . '";';
	            }
	            break;
	        case 'jump' : 
	            if ($url) {
	                $js .= 'window.location.href="' . $url . '";';
	            }
	            break;
	        default :
	            break;
	    }
		$js .= '</script>';
		echo $js;
		exit;
	}

	/**
	 * 判断是否是post传输
	 * @return [booler]
	 */
	public function isPost() {
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	/**
	 * 加载分页数据
	 * @param integer $page 当前页
	 * @param integer $pages 总页数
	 * @param string $url 跳转url地址
	 * @return [str]
	 */
	public function page($page = 1, $pages = 1, $url = '') {
		//最多显示多少个页码
		$_pageNum = 5;
		//当前页面小于1 则为1
		$page = $page < 1 ? 1 : $page;
		//当前页大于总页数 则为总页数
		$page = $page > $pages ? $pages : $page;
		//页数小于当前页 则为当前页
		$pages = $pages < $page ? $page : $pages;

		//计算开始页
		$_start = $page - floor($_pageNum / 2);
		$_start = $_start < 1 ? 1 : $_start;
		//计算结束页
		$_end = $page + floor($_pageNum / 2);
		$_end = $_end > $pages ? $pages : $_end;

		//当前显示的页码个数不够最大页码数，在进行左右调整
		$_curPageNum = $_end - $_start + 1;
		//左调整
		if($_curPageNum < $_pageNum && $_start > 1){ 
			$_start = $_start - ($_pageNum - $_curPageNum);
			$_start = $_start < 1 ? 1 : $_start;
			$_curPageNum = $_end - $_start + 1;
		}
		//右边调整
		if($_curPageNum < $_pageNum && $_end < $pages){
			$_end = $_end + ($_pageNum - $_curPageNum);
			$_end = $_end > $pages ? $pages : $_end;
		}

		$_pageHtml = '<div class="row">';
		$_pageHtml .= '<div class="col-xs-6 col-xs-offset-3 col-sm-8 col-sm-offset-4 col-md-7 col-md-offset-4">';
		$_pageHtml .= '<nav>';
		$_pageHtml .= '<ul class="pagination">';
		if ($_start == $page) {
			$_pageHtml .= '<li class="disabled"> <a>';
		} else {
			$_pageHtml .= '<li> <a href="'.$url.'?page='.($page - 1).'">';
		}
		$_pageHtml .= '&laquo;</a> </li>';
		for ($i = $_start; $i <= $_end; $i++) {
			if($i == $page){
				$_pageHtml .= '<li class="active"> <a> '.$i.' <span class="sr-only">(current)</span> </a> </li>';
			}else{
				$_pageHtml .= '<li> <a href="'.$url.'?page='.$i.'">'.$i.'</a> </li>';
			}
		}
		
		if($page == $_end){
			$_pageHtml .= '<li class="disabled"> <a>&raquo;</a> </li>';
		} else {
			$_pageHtml .= '<li> <a href="'.$url.'?page='.($page + 1).'">&raquo;</a> </li>';
		}
		$_pageHtml .= '</ul> </nav> </div> </div>'; 
		return $_pageHtml;
	}
}
