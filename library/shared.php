<?php

/**
 * 检查是否为开发环境并设置是否记录错误日志
 */
function setReporting(){
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors','On');
        ini_set('error_log',ROOT.DS. 'tmp' .DS. 'logs' .DS. 'error.log');
    }
}
 
/**
 * 检测敏感字符转义（Magic Quotes）并移除他们
 * @param  [str] $value [转义前字符]
 * @return [str] $value [转义后字符]
 */
function stripSlashDeep($value){
    $value = is_array($value) ? array_map('stripSlashDeep',$value) : stripslashes($value);
    return $value;
}

/**
 * 过滤字符转移
 */
function removeMagicQuotes(){
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashDeep($_GET);
        $_POST = stripSlashDeep($_POST);
        $_COOKIE = stripSlashDeep($_COOKIE);
    }
}
 
/**
 * 检测全局变量设置（register globals）并移除他们
 */
function unRegisterGlobals(){
    if (ini_get('register_globals')) {
        $array = array('_SESSION','_POST','_GET','_COOKIE','_REQUEST','_SERVER','_ENV','_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}
 
/**
 * 定义get参数，避免notice错误
 * @param $str
 * @return blend
 */
function _get($k = null, $default = null) {
    if ($k === null) {
        return $_GET;
    }
    return isset($_GET[$k]) ? $_GET[$k] : $default;
}

/**
 * 定义post参数，避免notice错误
 * @param $str
 * @return blend
 */                                                     
function _post($k = null, $default = null) {
    if ($k === null) {
        return $_POST;
    }
    return isset($_POST[$k]) ? $_POST[$k] : $default;                            
}

/**
 * 定义session参数，避免notice错误
 * @param $str
 * @return blend
 */                                                     
function getSession($k = null, $default = null) {
    if ($k === null) {
        return $_SESSION;
    }
    return isset($_SESSION[$k]) ? $_SESSION[$k] : $default;                             
}

/**
 * 主请求方法，主要目的拆分URL请求
 */
function callHook() {
    global $url;
    $urlArray = array();
    $urlArray = explode('/', $url);
    if (empty($urlArray[0])) {
        $controller = 'indexs';
        $action = 'index';
        $queryString = array();
    } else {
        $controller = $urlArray[0];
        array_shift($urlArray);
        $action = isset($urlArray[0]) && $urlArray[0] ? $urlArray[0] : 'index';
        array_shift($urlArray);
        $queryString = $urlArray;
    }
    $controller = ucwords($controller);
    $controllerName = $controller;
    $model = rtrim($controller, 's');
    $controller .= 'Controller';
    $dispatch = new $controller($model,$controllerName,$action);
    if ((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch,$action),$queryString);
    } else {
        /* 生成错误代码 */
    }
}
 
/**
 * 自动加载控制器和模型
 */
function __autoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . ucwords($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . ucwords($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . ucwords($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . ucwords($className) . '.php');
    } else {
        /* 生成错误代码 */
    }
}
 
setReporting();
removeMagicQuotes();
unRegisterGlobals();
session_start();
callHook();
