<?php
	session_start(); // Start or Resume Session
	
	require('config.php');
	
	//composer auto load libraries
	require ('vendor/autoload.php');

	//Error reporting for debugging during development
	if(DEVELOPMENT_MODE == true){
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL); 
	} 
	else {
		//errors will not be displayed on the pages but log to files
		error_reporting(E_ALL);
		ini_set('log_errors', 'On');
		ini_set('error_log', 'error.log');
		ini_set('display_errors','Off');
	}
	//
	if(!empty(DEFAULT_TIMEZONE)){
		date_default_timezone_set(DEFAULT_TIMEZONE);
	}
	
	// Application configurations Settings

	/**
     * Initialize Model Class From Model Dir
     * @return null
     */
	function autoloadModel($className) {
		$filename = MODELS_DIR . $className . ".php";
		if (is_readable($filename)) {
			require $filename;
		}
	}

	/**
     * Initialize Controller Classes From Controller Dir
     * @return null
     */
	function autoloadController($className) {
		$filename = CONTROLLERS_DIR . $className . ".php";
		if (is_readable($filename)) {
			require $filename;
		}
	}
	
	/**
     * Initialize Libraries Classes From Libs Dir
     * @return boolean
     */
	function autoloadLibrary($className) {
		$filename = LIBS_DIR . $className . ".php";
		if (is_readable($filename)) {
			require $filename;
		}
	}
	
	/**
     * Initialize Helper Classes From helper Dir
     * @return null
     */
	function autoloadHelper($className) {
		$filename = HELPERS_DIR . $className . ".php";
		if (is_readable($filename)) {
			require $filename;
		}
	}
	
	// Register Autoloaders
	spl_autoload_register("autoloadModel");
	spl_autoload_register("autoloadController");
	spl_autoload_register("autoloadLibrary");
	spl_autoload_register("autoloadHelper");
	
	
	
	//Initialize Global Functions Helpers
	require(HELPERS_DIR . 'Functions.php');

	$lang = new Lang;// Initialize language class and load default language phrases
	$csrf = new Csrf;// Initialize Csrf class and generate new application token
	$csrf_token = $csrf::$token; 
	

	// Application Core Files
	require(SYSTEM_DIR . 'BaseController.php');
	require(SYSTEM_DIR . 'SecureController.php');
	require(SYSTEM_DIR . 'BaseView.php');
	require(SYSTEM_DIR . 'Router.php');
	
	//display page with the exceptions
	function exception_handler($exception){
		$view = new BaseView();
		$view->render("errors/error_server.php", $exception, "info_layout.php");
		exit;
	}

	//Display application exception in a custom page
	set_exception_handler('exception_handler');

	$page = new Router;
	$page->init(); // Bootstrap Page with the Current URL
	
	