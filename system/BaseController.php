<?php 
defined('ROOT') OR exit('No direct script access allowed');

/**
* Application Base Controller.
* Other Controllers must extend to the class 
* Controllers which do not need page authentication and resource authorization can extend to this class
*/
class BaseController{
	/**
	 * use to check if current controller can continue to dispatch page after authentication or authorization
	 * @var bool
	 */
	public $status = 200;

	/**
	 * Instance of the base view class. Use for rendering pages
	 * @var BaseView
	 */
	public $view = null;

	/**
	 * Instance of the PDODB class
	 * Provide Data access laeyer to the database
	 * @var PDODb
	 */
	public $db = null;

	/**
	 * Contains basic properties of the current page route
	 * @var object
	 */
	public $route = null;
	
	/**
	 * order query type desc|asc from $_GET['ordertype']
	 * @var string
	 */
	public $ordertype = ORDER_TYPE;


	/**
	 * current page record id from router url pagename/[rec_id]
	 * @var string
	 */
	public $rec_id = null;


	/**
	 * return value after execution of page query instead of rendering the result to the browser
	 * @var bool
	 */
	public $return_value = false;

	/**
	 * value set in the settion that will be diplay in page after page action or redirect 
	 * @var string
	 */
	public $flash_msg = "";

	
	/**
	 * the table name associated to the current page
	 * @var string
	 */
	public $tablename = null;

	/**
	 * Sanitized Object from $_GET
	 * @var array
	 */
	public $request = null;

	/**
	 * Sanitized Object from $_POST
	 * @var array
	 */
	public $post = null;
	
	/**
	 * POST Data after sanitization and validation ready for database interaction
	 * @var array
	 */
	public $modeldata = array();
	
	/**
	 * Enable soft delete of record. A field is flagged as deleted in the database table
	 * @var bool
	 */
	public $soft_delete = false;

	/**
	 * Soft delete flag field Name
	 * @var string
	 */
	public $delete_field_name = "is_deleted";

	/**
	 * Soft delete field value
	 * @var string
	 */
	public $delete_field_value = "1";

	/**
	 * File upload settings if their should be any upload on any page
	 * @var array
	 */
	public $file_upload_settings = array();


	/**
	 * Table fields associated with the current page
	 * @var array
	 */
	public $fields = array();

	/**
	 *  Enable captcha validation on form
	 * @var bool
	 */
	public $validate_captcha = false;
	
	/**
	 *  set whether to filter POST data by removing empty fields
	 * @var bool
	 */
	public $filter_vals = false;
	
	/**
	 *  set whether to filter validation rules by excluding fields not in the POST Data
	 * @var bool
	 */
	public $filter_rules = false;


	function __construct(){
		$this->view = new BaseView; //initialize the view renderer

		if(is_post_request()){
			Csrf::cross_check();
			$this->post = new stdClass;
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			if(!empty($post)){
				foreach($post as $obj => $val){
					$this->post->$obj = $val; //pass each GET data to the current request class property
				}
			}
		}
		
		$this->set_request($_GET);

		$this->file_upload_settings['summernote_img_upload'] = array(
			"title" => "{{random}}",
			"extensions" => ".jpg,.png,.gif,.jpeg",
			"limit" => "10",
			"filesize" => "3",
			"returnfullpath" => false,
			"filenameprefix" => "",
			"uploadDir" => "uploads/files/"
		);
		
		$this->file_upload_settings['photo'] = array(
			"title" => "{{random}}",
			"extensions" => ".jpg,.png,.gif,.jpeg",
			"limit" => "1",
			"filesize" => "3",
			"returnfullpath" => true,
			"filenameprefix" => "",
			"uploadDir" => "uploads/files/"
		);
	

		$this->file_upload_settings['phone'] = array(
			"title" => "{{random}}",
			"extensions" => ".jpg,.png,.gif,.jpeg",
			"limit" => "1",
			"filesize" => "3",
			"returnfullpath" => true,
			"filenameprefix" => "",
			"uploadDir" => "uploads/files/"
		);
	

		$this->file_upload_settings['content'] = array(
			"title" => "{{random}}",
			"extensions" => "",
			"limit" => "1",
			"filesize" => "3",
			"returnfullpath" => true,
			"filenameprefix" => "",
			"uploadDir" => "uploads/files/"
		);
	

		$this->file_upload_settings['download'] = array(
			"title" => "{{random}}",
			"extensions" => "",
			"limit" => "1",
			"filesize" => "3",
			"returnfullpath" => true,
			"filenameprefix" => "",
			"uploadDir" => "uploads/files/"
		);
	

		$this->status = AUTHORIZED;
	}

	/**
     * Init DB Connection 
     * Which can be use to perform DB queries
     * @return PDODb
     */
	function GetModel(){
		//Initialse New Database Connection
		$this->db = new PDODb(DB_TYPE, DB_HOST , DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_CHARSET);
		if($this->soft_delete){
			$delete_field = $this->delete_field_name;
			$param = array($this->delete_field_value);
			$this->db->where("($delete_field IS NULL OR $delete_field != ?)", $param); //query only records not deleted
		}
		return $this->db;
	}

	/**
     * Set current page request from $_GET 
     * @return null
     */
	function set_request($get = array()){
		$this->request = new stdClass;
		// filter all values of the GET Request
		$get = filter_var_array($get, FILTER_SANITIZE_STRING);
		if(!empty($get)){
			foreach($get as $obj => $val){
				$this->request->$obj = $val; //pass each request data to the current page request property
			}
		}
	}

	/**
     * Set the route properties and pass it to the view
     * @return null
     */
	function set_route($route){
		$route->request = $this->request;
		$this->route = $this->view->route  = $route;
	}

	/**
	 * Set Current Page Start and Page Count
	 * $page_count Set Max Record to retrive per page
	 * $fieldvalue Table Field Value 
	 * @return array
	 */
	function get_pagination($page_count = MAX_RECORD_COUNT){
		$request = $this->request;
		$limit_count = (!empty($request->limit_count) ? $request->limit_count : $page_count);
		$limit_start = (!empty($request->limit_start) ? $request->limit_start : 1);
		$limit_start = ($limit_start - 1) * $limit_count;

		//pass the pagination to view
		$this->view->limit_count = $limit_count;
		$this->view->limit_start = $limit_start;
		return array($limit_start, $limit_count);
	}
	
	/**
     * validate post array using gump library
     * sanitize input array based on the page sanitize rule
     * validate data based on the set of defined rules
     * @var $filter_rules = true: will validate post data only for posted array data if field name is not set in the postdata
     * @return array
     */
	function validate_form($modeldata){
		if(!empty($this->sanitize_array)){
			$modeldata = GUMP::filter_input($modeldata, $this->sanitize_array);
		}

		if($this->validate_captcha){
			$form_captcha = strtoupper(!empty($modeldata['form_captcha_code']) ? $modeldata['form_captcha_code'] : '0');
			$session_captcha = strtoupper(get_session("captcha"));
			if($form_captcha !== $session_captcha){
				$this->view->page_error[] = "Invalid Captcha Code";
			}
		}

		$rules = $this->rules_array;
		if($this->filter_rules == true){
			$rules = array(); //set new rules
			//set rules for only fields in the posted data
			foreach($modeldata as $key => $val){
				if(array_key_exists($key, $this->rules_array)){
					$rules[$key] =  $this->rules_array[$key];
				}
			}
		}
		//accept posted fields if they are part of the page fields
		$fields = $this->fields;
		if(!empty($fields)){
			foreach($modeldata as $key => $val){
				if(!in_array($key, $fields)){
					unset($modeldata[$key]); //remove field if not part of the field list
				}
			}
		}
		$is_valid = GUMP::is_valid($modeldata, $rules);
		// remove empty field values
		if($this->filter_vals == true){
			$modeldata = array_filter($modeldata, function($val){
				if($val === "" || is_null($val)){
					return false;
				}
				else{
					return true;
				}
			});
		}
		if($is_valid !== true) {
			if(is_array($is_valid)){
				foreach($is_valid as  $error_msg){
					$this->view->page_error[] = strip_tags($error_msg);
				}
			}
			else{
				$this->view->page_error[] = $is_valid;
			}
		}

		if(empty($modeldata)){
			$this->view->page_error[] = "UnAccepted Fields";
		}
		return $modeldata;
	}
	


	/**
     * Check if the PostData validation failed
     * @return bool
     */
	function validated(){
		return (empty($this->view->page_error) ? true : false);
	}
	
	/**
     * Check if the PostData validation failed
     * @return bool
     */
	function redirect($default_page = null){
		if($this->return_value){
			return $this->rec_id;
		}
		elseif (is_ajax()) {
			render_json($this->flash_msg);
		} else {
			$redirect = (!empty($this->request->redirect) ? $this->request->redirect : $default_page);
			redirect_to_page($redirect);
		}
	}
	
	/**
	 * return value if request is being called by another controller
     * Check if there's any error from  the database and pass it to the page view
	 * render error msg as json request if request type is ajax
     * @return null
     */
	function render_view($viewname, $data = null, $layout = "main_layout.php"){
		if($this->return_value){
			return $this->rec_id;
		}
		else{
			$this->view->render($viewname, $data, $layout);
		}
	}

	/**
	 * return value if request is being called by another controller
     * Check if there's any error from  the database and pass it to the page view
	 * render error msg as json request if request type is ajax
     * @return null
     */
	function set_page_error($page_error = null){
		if(!empty($this->db->getLastError())){
			$this->view->page_error[] = $this->db->getLastError(); 
		}

		if($page_error){
			if(is_array($page_error)){
				$this->view->page_error = $page_error;
			}
			else{
				$this->view->page_error[] = $page_error;
			}
		}
		return $this->rec_id;
	}

	/**
	 * Set msg that will be display to user in a session. 
	 * Can Be Displayed on Any View.
	 * @return null
	 */
	function set_flash_msg($msg, $type = "success", $dismissable = true, $showduration = 5000)
	{
		$this->flash_msg = $msg;
		if (!is_ajax() && $msg !== '') {
			$class = null;
			$closeBtn = null;
			if ($type != 'custom') {
				$class = "alert alert-$type";
				if ($dismissable == true) {
					$class .= " alert-dismissable";
					$closeBtn = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				}
			}

			$msg = '<div data-show-duration="' . $showduration . '" id="flashmsgholder" class="' . $class . ' animated bounce">
							' . $closeBtn . '
							' . $msg . '
					</div>';

			set_session("MsgFlash", $msg);
		}
	}


	/**
     * Concat array  values with comma if request value is a simple array
     * Specific for this Framework Only
     * @arr $_POST data
     * @return array
     */
	function format_request_data($arr){
		foreach($arr as $key => $val){
			if(is_array($val)){
				$arr[$key] = implode(",", $val);
			}
		}
		return $arr;
	}
	
	/**
     * Concat Array  Values With Comma for multiple post data
     * Specific for this Framework Only
     * @arr $_POST data
     * @return array
     */
	function format_multi_request_data($arr){
		$alldata = array();
		foreach($arr as $key => $val){
			$combine_vals = $val;
			if(is_array($val)){
				$combine_vals = recursive_implode($val, "");
			}
			//merge all values of each input into one string and check if each post data contains value
			if(!empty($combine_vals)){
				$alldata[] = $this -> format_request_data($val);
			}
		}
		return $alldata;
	}

	/**
     * Delete files
	 * split file path if they are separated by comma
     * @files Array
     * @return null
     */
	function delete_record_files($files, $field){
		foreach($files as $file_path){
			$comma_paths = explode( ',', $file_path[$field] );
			foreach($comma_paths as $file_url){
				try{
					$file_dir_path = str_ireplace( SITE_ADDR , "" , $file_url ) ;
					@unlink($file_dir_path);
				}
				catch(Exception $e) {
				  // error_log('Message: ' .$e->getMessage());
				}
			}
		}
	}
	
	
	/**
     * upload files and return file paths
	 * @var $fieldname File upload filed name
     * @return null
     */
	function get_uploaded_file_paths($fieldname){
		$uploaded_files = "";
		if(!empty($_FILES[$fieldname])){
			$uploader = new Uploader;
			$upload_settings = $this->file_upload_settings[$fieldname];
			$upload_data = $uploader->upload($_FILES[$fieldname], $upload_settings );
			if($upload_data['isComplete']){
				$arr_files = $upload_data['data']['files'];
				if(!empty($arr_files)){
					if(!empty($upload_settings['returnfullpath'])){
						$arr_files = array_map( "set_url", $arr_files ); // set files with complete url of the website
					}
					$uploaded_files = implode("," , $arr_files);
				}
			}
			if($upload_data['hasErrors']){
				$errors = $upload_data['errors'];
				foreach($errors as $key=>$val){
					$this->view->page_error[] = "$key : $val[$key]";
				}
			}
		}
		return $uploaded_files;
	}
	
	/**
     * For getting uploaded file as Blob type
     * can be use to insert blob data into the database
	 * @var $fieldname File upload filed name
     * @return object
     */
	function get_uploaded_file_data($fieldname){
		if(!empty($_FILES[$fieldname])){
			$file_name = $_FILES[$fieldname]['tmp_name'];
			return file_get_contents($file_name);
		}
		return null;
	}
	
}