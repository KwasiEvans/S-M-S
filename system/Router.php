<?php

/**
 * Router Class 
 * this is a dynamic router that simply parses url and dispatch Controller/Action with optional arguments
 * the Controller Name Must start with Capital Letter And End With Controller UserController
 * Action Names must be Lower case
 * 
 * Examples
 *	users OR users/index
 *	users/{id} OR users/view/{id}
 *  users/index/{field}/{value}  OR users/{field}/{value}
 *  users/index/{field}/{value}/.../.../
 *  users/edit/{id}
 *  users/delete/{id}
 * 
 * Router Object can be access statica
 * Examples
 * Router :: $page_name //returns current Controller Name
 * Router :: $page_action //returns current Controller Action
 * @category  URLParser, PageDispatcher
 */
class Router
{
	/**
	 * Get The Current Page Name
	 * @var string
	 */
	public static $page_name = null;

	/**
	 *	Get The Current Page Action
	 * @var string
	 */
	public static $page_action = null;

	/**
	 * Get The Current Page Id If Available
	 * @var string
	 */
	public static $page_id = null;

	/**
	 * Get The Current Page Field Name Or Category If Available
	 * @var string
	 */
	public static $field_name = null;

	/**
	 * Get The Current Page Field Value If Available
	 * @var string
	 */
	public static $field_value = null;

	/**
	 * Get The Current Page Full URL Relative Path
	 * @var string
	 */
	public static $page_url = null;

	/**
	 * Get The Current Page Controller Name
	 * @var string
	 */
	public static $controller_name = null;

	/**
	 * Get The Current Page Controller Name
	 * @var string
	 */
	public $is_partial_view = false;

	/**
	 * 
	 * @var array
	 */
	public $page_props = array();

	/**
	 * The Layout file that will be use to render the page
	 * Overrides the default  page layout
	 * @var string
	 */
	public $force_layout = null;


	/**
	 * Get The Current Page Controller Name
	 * @var string
	 */
	public $partial_view = null;

	/**
	 * Current page get request
	 * @var string
	 */
	public $request = array();

	/**
	 * Start page Dispatch From Current URL
	 * @var string
	 */
	function init()
	{
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		// for now, we are only interested with the path only.
		$page_url  = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		$path = parse_url($page_url, PHP_URL_PATH);
		$this->run($path);
	}

	/**
	 * Dispatch page based on the url
	 * Can be used to dispatch any page
	 * @return string
	 */
	function run($url)
	{
		self::$page_url = $url;
		$url_segment = array_map('urldecode', explode("/", rtrim($url, "/")));
		$page = strtolower(!empty($url_segment[0]) ? $url_segment[0] : DEFAULT_PAGE);
		
		// all action name should be in lower case
		$action = strtolower((!empty($url_segment[1]) ? $url_segment[1] : DEFAULT_PAGE_ACTION));
		$fieldname = (!empty($url_segment[2]) ? $url_segment[2] : null);
		$fieldvalue = (!empty($url_segment[3]) ? $url_segment[3] : null);

		//Remove any unwanted characters as these might be used to interact with the database
		$page = filter_var($page, FILTER_SANITIZE_STRING);
		$action = filter_var($action, FILTER_SANITIZE_STRING);
		$fieldname = filter_var($fieldname, FILTER_SANITIZE_STRING);
		$fieldvalue = filter_var($fieldvalue, FILTER_SANITIZE_STRING);
		
		//if link action name is 'list' then change it to index [e.g (products/list) >>  (products/index)]
		//action name cannot be list
		if ($action == "list") {
			$action = "index";
		}

		//array of arguments that will be passed to the controller function
		$args = array_slice($url_segment, 2);
		$args = filter_var_array($args, FILTER_SANITIZE_STRING);

		$page_id = (!empty($args[0]) ? $args[0] : null);
		// all controller class name must start with capital letter
		$controller_name = ucfirst($page) . "Controller";

		if (class_exists($controller_name, true)) {
			// Set Router Page Variables. They can be accessed by calling Router::$page_variable_name
			self::$page_name = $page;
			self::$page_action = $action;
			self::$page_id = $page_id;
			self::$field_name = $fieldname;
			self::$field_value = $fieldvalue;
			self::$controller_name = $controller_name;

			if (method_exists($controller_name, $action)) {
				// Initialite Controller Class
				$controller = new $controller_name;
				if ($this->is_partial_view == true) {
					//if set as partial_view	will display the page without the layout
					$controller->view->is_partial_view = $this->is_partial_view;
					if (!empty($this->page_props) && is_array($this->page_props)) {
						foreach ($this->page_props as $key => $val) {
							$controller->view->$key = $val;
						}
					}
					$controller->set_request($this->request);
					$controller->view->page_props = $this->page_props;
					$controller->view->partial_view = $this->partial_view;
				}
				// use the force layout when force layout is set
				$controller->view->force_layout = $this->force_layout;
				if (is_post_request()) {
					//Pass postdata as argument to the page method
					//please note: input sanitization is handled by the controller
					$args[] = $_POST;
				}
				if (is_callable(array($controller, $action))) {

					$route = new stdClass;

					$route->page_name = $page;
					$route->page_action = $action;
					$route->page_id = $page_id;
					$route->page_url = $url;
					$route->field_name = $fieldname;
					$route->field_value = $fieldvalue;
					$route->controller = $controller_name;
					$route->params = $args;

					$controller->set_route($route);

					if($controller->status == AUTHORIZED){
						// Call Controller Class And Pass All Arguments to the Controller Action
						call_user_func_array(array($controller, $action), $args);
					}
					elseif($controller->status == UNAUTHORIZED){ //when user is not logged
						//$view->page_error="Not Logged In";
						$current_url = get_current_url();
						if (!empty($current_url )) {
							set_session("login_redirect_url", $current_url);
						}
						$controller->render_view("index/login.php", null, "main_layout.php");
					}
					elseif($controller->status == FORBIDDEN){
						$controller->render_view("errors/forbidden.php", null, "info_layout.php");
					}
					elseif($controller->status == NOROLE){
						$controller->render_view("errors/error_no_permission.php", null, "info_layout.php");
					}
				} else {
					$this->page_not_found("$action Action  Was  Not Found In $controller_name");
				}
			} else {
				$this->page_not_found("$action Action  Was  Not Found In $controller_name");
			}
		} else {
			if ($this->is_partial_view == true) {
				echo "<div class='alert alert-danger'><b>$controller_name</b> Was  Not Found In Controller Directory. <b>Please Check </b>" . CONTROLLERS_DIR . "</div>";
			} else {
				$this->page_not_found("<b>$controller_name</b> Was  Not Found In Controller Directory. <b>Please Check </b>" . CONTROLLERS_DIR);
			}
		}
	}

	/**
	 * Display Error Page When Page Or Page Action Not Found
	 * @var string
	 */
	function page_not_found($msg)
	{
		$view = new BaseView();
		$view->render("errors/error_404.php", $msg, "info_layout.php");
		exit;
	}
}
