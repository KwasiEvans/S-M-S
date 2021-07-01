<?php

/**
 * Public Functions Specific for this Framework
 * @category  General
 */


/**
 * Get Logged In User Details From The Session
 * @param $field Get particular field value of the active user  otherwise return array of active user fields 
 * @return string | array
 */
function get_active_user($field = null, $default_value = null)
{
	if (!empty($field)) {
		$user_data = get_session('user_data');
		if (!empty($user_data) && !empty($user_data[$field])) {
			return $user_data[$field];
		}
		return $default_value;
	} else {
		return get_session('user_data');
	}
}

function slugify($text)
{
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// trim
	$text = trim($text, '-');

	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);

	// lowercase
	$text = strtolower($text);
	return $text;
}

/**
 * Convert a multi-dimensional, associative array to CSV data
 * @param  array $data the array of data
 * @return string       CSV text
 * https://coderwall.com/p/zvzwwa/array-to-comma-separated-string-in-php
 */
function arr_to_csv($data)
{
	# Generate CSV data from array
	$fh = fopen('php://temp', 'rw'); # don't create a file, attempt # to use memory instead
	# write out the headers
	fputcsv($fh, array_keys(current($data)));
	# write out the data
	foreach ($data as $row) {
		fputcsv($fh, $row);
	}
	rewind($fh);
	$csv = stream_get_contents($fh);
	fclose($fh);
	return $csv;
}

/**
 * Recursively implodes an array with optional key inclusion
 * 
 * Example of $include_keys output: key, value, key, value, key, value
 * 
 * @access  public
 * @param   array   $array         multi-dimensional array to recursively implode
 * @param   string  $glue          value that glues elements together	
 * @param   bool    $include_keys  include keys before their values
 * @param   bool    $trim_all      trim ALL whitespace from string
 * @return  string  imploded array
 */
function recursive_implode(array $array, $glue = ',', $include_keys = false, $trim_all = false)
{
	$glued_string = '';
	// Recursively iterates array and adds key/value to glued string
	array_walk_recursive($array, function ($value, $key) use ($glue, $include_keys, &$glued_string) {
		$include_keys and $glued_string .= $key . $glue;
		$glued_string .= $value . $glue;
	});
	// Removes last $glue from string
	strlen($glue) > 0 and $glued_string = substr($glued_string, 0, -strlen($glue));
	// Trim ALL whitespace
	$trim_all and $glued_string = preg_replace("/(\s)/ixsm", '', $glued_string);
	return (string) $glued_string;
}

/*
 * Sometimes REMOTE_ADDR does not returns the correct IP address of the user. 
 * The reason behind this is to use Proxy. In that situation, use the following code to get real IP address of user in PHP.
*/
function get_user_ip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		//ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		//ip pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

/**
 * Get The Current Request Method
 * @example (post,get,put,delete,...)
 * @return string
 */
function request_method()
{
	return strtolower($_SERVER['REQUEST_METHOD']);
}

/**
 * Get The Current Request Method
 * @example (post,get,put,delete,...)
 * @return string
 */

function is_post_request()
{
	return (request_method() == 'post');
}




/**
 * Dispatch Content in JSON Formart
 * @param $data Data to be Output
 * @param $errors Errors If Any
 * @param $status Html Request Status
 * @return JSON String
 */

function render_json($data, $status = 'ok')
{
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($data);
	exit;
}

function render_error($response = null, $code = 501)
{
	if (is_array($response)) {
		$response = json_encode($response);
	}
	header("HTTP/1.1 $code $response", true, $code);
	exit;
}

/**
 * encode data to json and convert special characters to unicode 
 * for display in HTMl attribute
 * @return  string
 */
function json_encode_quote($data)
{
	return json_encode($data, JSON_HEX_APOS | JSON_HEX_QUOT);
}


/**
 * Check if there is active User Logged In
 * @return boolean
 */
function user_login_status()
{
	return (!empty(get_session('user_data')) ? true : false);
}

/**
 * Convinient Function To Redirect to a url
 * @example redirect_to_page("https://phprad.com");  
 * @return  null
 */
function redirect($url)
{
	header("location:$url");
}

/**
 * Convinient Function To Redirect to Another Page
 * @example redirect_to_page("users/view/".USER_ID);  
 * @return  null
 */
function redirect_to_page($path = null)
{
	header("location:" . SITE_ADDR . $path);
}

/**
 * Convinient Function To Redirect to Page Action
 * @example redirect_to_action("index");  
 * @return  null
 */
function redirect_to_action($action_name)
{
	$page = Router::$page_name;
	header("location:" . SITE_ADDR . $page . "/" . $action_name);
}

/**
 * Set Image Src 
 * Convinient Function To Resize Image Via Url of the Image Src if the src is from the same origin then image can be resize
 * @example <img src="<?php echo set_img_src('uploads/images/89njdh4533.jpg',50,50); ?>" />
 * @return  string
 */
function set_img_src($imgsrc, $width = null, $height = null, $returnindex = 0)
{
	if (!empty($imgsrc)) {
		$arrsrc = explode(",", $imgsrc);
		$src = $arrsrc[$returnindex];
		$imgpath = "helpers/timthumb.php?src=$src";
		$imgpath .= ($height != null ? "&h=$height" : null);
		$imgpath .= ($width != null ? "&w=$width" : null);
		return $imgpath;
	}
	return null;
}


/**
 * Set Application Session Variable 
 * @return  object
 */
function set_session($session_name, $session_value)
{
	clear_session($session_name);
	$_SESSION[APP_ID . $session_name] = $session_value;
	return $_SESSION[APP_ID . $session_name];
}

/**
 * Update Session Value (if Session is an Array) 
 * @return  object
 */
function update_session($session_name, $field, $value)
{
	$_SESSION[APP_ID . $session_name][$field] = $value;
	return $_SESSION[APP_ID . $session_name];
}

/**
 * Clear Session
 * @return  boolean
 */
function clear_session($session_name)
{
	$_SESSION[APP_ID . $session_name] = null;
	unset($_SESSION[APP_ID . $session_name]);
	return true;
}

/**
 * Return Session Value
 * @return  object
 */
function get_session($session_name)
{
	if (!empty($_SESSION[APP_ID . $session_name])) {
		return $_SESSION[APP_ID . $session_name];
	}
	return null;
}

/**
 * Return Session Array key Value (if Session is an Array)
 * @return  object
 */
function get_session_field($session_name, $field)
{
	if (isset($_SESSION[APP_ID . $session_name])) {
		return $_SESSION[APP_ID . $session_name][$field];
	}
	return null;
}

/**
 * Force Download of The File
 * @return boolean
 */
function download_file($file_path, $savename = null, $showsavedialog = false)
{
	if (!empty($file_path)) {

		if ($showsavedialog == false) {
			header('Content-Type: application/octet-stream');
		}

		if (empty($savename)) {
			$savename = basename($file_path);
		}

		header('Content-Transfer-Encoding: binary');
		header('Content-disposition: attachment; filename="' . $savename . '"');
		header('Content-Description: File Transfer');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		ob_clean();
		flush();
		readfile($file_path);

		return true;
	}
	return false;
}

/**
 * Retrieve Content of From external Url
 * @example echo httpGet("http://phprad.com/system/phpcurget/");
 * @return string
 */
function http_get($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch,CURLOPT_HEADER, false); 
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}


/**
 * Retrieve Content of From external Url Using POST Request
 * @example echo http_post("http://phprad.com/system/phpcurlpost/");
 * @return string
 */
function http_post($url, $params = array())
{
	$postData = '';
	//create name value pairs seperated by &
	foreach ($params as $k => $v) {
		$postData .= $k . '=' . $v . '&';
	}
	$postData = rtrim($postData, '&');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, count($postData));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	$output = curl_exec($ch);

	curl_close($ch);
	return $output;
}


/**
 * will return current DateTime in Mysql Default Date Time Format
 * @return  string
 */
function datetime_now()
{
	return date("Y-m-d H:i:s");
}

/**
 * will return current Time in Mysql Default Date Time Format
 * @return  string
 */
function time_now()
{
	return date("H:i:s");
}

/**
 * will return current Date in Mysql Default Date Time Format
 * @return  string
 */
function date_now()
{
	return date("Y-m-d");
}

/**
 * will return 
 * @return  string
 */
function format_date($date_str, $format = 'Y-m-d H:i:s')
{
	if (!empty($date_str)) {
		return date($format, strtotime($date_str));
	}
	return date($format);
}


/**
 * Parse Date Or Timestamp Object into Relative Time (e.g. 2 days Ago, 2 days from now)
 * @return  string
 */
function relative_date($date)
{
	if (empty($date)) {
		return "No date provided";
	}

	$periods         = array("sec", "min", "hour", "day", "week", "month", "year", "decade");
	$lengths         = array("60", "60", "24", "7", "4.35", "12", "10");

	$now             = time();

	//check if supplied Date is in unix date form
	if (is_numeric($date)) {
		$unix_date        = $date;
	} else {
		$unix_date         = strtotime($date);
	}


	// check validity of date
	if (empty($unix_date)) {
		return "Bad date";
	}

	// is it future date or past date
	if ($now > $unix_date) {
		$difference     = $now - $unix_date;
		$tense         = "ago";
	} else {
		$difference     = $unix_date - $now;
		$tense         = "from now";
	}

	for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
		$difference /= $lengths[$j];
	}

	$difference = round($difference);

	if ($difference != 1) {
		$periods[$j] .= "s";
	}

	return "$difference $periods[$j] {$tense}";
}


/**
 * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016)
 * @return  string
 */
function human_date($date)
{
	if (empty($date)) {
		return "Null date";
	}
	if (is_numeric($date)) {
		$unix_date        = $date;
	} else {
		$unix_date         = strtotime($date);
	}
	// check validity of date
	if (empty($unix_date)) {
		return "Bad date";
	}
	return date("jS F, Y", $unix_date);
}

/**
 * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016)
 * @return  string
 */
function human_time($date)
{
	if (empty($date)) {
		return "Null date";
	}
	if (is_numeric($date)) {
		$unix_date        = $date;
	} else {
		$unix_date         = strtotime($date);
	}
	// check validity of date
	if (empty($unix_date)) {
		return "Bad date";
	}
	return date("h:i:s", $unix_date);
}

/**
 * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March, 2016 02:30)
 * @return  string
 */
function human_datetime($date)
{
	if (empty($date)) {
		return "Null date";
	}
	if (is_numeric($date)) {
		$unix_date = $date;
	} else {
		$unix_date = strtotime($date);
	}
	// check validity of date
	if (empty($unix_date)) {
		return "Bad date";
	}
	return date("jS F, Y h:i", $unix_date);
}

/**
 * returns true if $needle is a substring of $haystack
 * @return  bool
 */

/**
 * Approximate to nearest decimal points
 * @return  string
 */
function approximate($val, $decimal_points = 2)
{
	return number_format($val, $decimal_points);
}

/**
 * Return String formatted in currency mode
 * @return  string
 */
function to_currency($val, $lang = 'en-US')
{
	$f = new NumberFormatter($lang, \NumberFormatter::CURRENCY);
	return $f->format($val);
}

/**
 * return a numerical representation of the string in a readable format
 * @return  string
 */
function to_number($val, $lang = 'en')
{
	$f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
	return $f->format($val);
}

/**
 * Trucate string
 * @return  string
 */
function str_truncate($string, $length = 50, $ellipse = '...')
{
	if (strlen($string) > $length) {
		$string = substr($string, 0, $length) . $ellipse;
	}
	return $string;
}

/**
 * Convert Number to words
 * @return  string
 */
function number_to_words($val, $lang = "en")
{
	$f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
	return $f->format($val);
}


/**
 * Set Cookie Value With Number of Days Before Expiring
 * @return  string
 */
function set_cookie($name, $value, $days = 30)
{
	$expiretime = time() + (86400 * $days);
	setcookie(APP_ID . $name, $value, $expiretime, "/");
}

/**
 * Get Cookie Value
 * @return  object
 */
function get_cookie($name)
{
	if (!empty($_COOKIE[APP_ID . $name])) {
		return $_COOKIE[APP_ID . $name];
	}
	return null;
}

/**
 * Clear Cookie Value
 * @return  boolean
 */
function clear_cookie($name)
{
	setcookie(APP_ID . $name, "", time() - 3600, "/");
	return true;
}
function array_change_key_name($array, $newkey, $oldkey)
{
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$array[$key] = array_change_key_name($value, $newkey, $oldkey);
		} else {
			$array[$newkey] =  $array[$oldkey];
		}
	}
	unset($array[$oldkey]);
	return $array;
}
/**
 * Generate a random string and characters from set of supplied data context
 * @return  string
 */
function random_chars($limit = 12, $context = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*_+-=')
{
	$l = ($limit <= strlen($context) ? $limit : strlen($context));
	return substr(str_shuffle($context), 0, $l);
}

/**
 * Generate a Random String From Set Of supplied data context
 * @return  string
 */
function random_str($limit = 12, $context = 'abcdefghijklmnopqrstuvwxyz1234567890')
{
	$l = ($limit <= strlen($context) ? $limit : strlen($context));
	return substr(str_shuffle($context), 0, $l);
}

/**
 * Generate a Random String From Set Of supplied data context
 * @return  string
 */
function random_num($limit = 10, $context = '1234567890')
{
	$l = ($limit <= strlen($context) ? $limit : strlen($context));
	return substr(str_shuffle($context), 0, $l);
}



/**
 * Generate a Random color String 
 * @return  string
 */
function random_color($alpha = 1)
{
	$red = rand(0, 255);
	$green = rand(0, 255);
	$blue = rand(0, 255);
	return "rgba($red,$blue,$green,$alpha)";
}

/**
 * Generate a strong hash value String 
 * @return  string
 */
function hash_value($text)
{
	$saltText = APP_ID;
	return md5($text . $saltText);
}

//xss mitigation functions
function xssafe($data, $encoding = 'UTF-8')
{
	return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
}

/**
 * Will Return A clean Html entities free from xss attacks
 * @return  string
 */
function xecho($data)
{
	echo xssafe($data);
}

/**
 * Concat Array  Values With Comma if REQUEST Value is Array
 * Specific for this Framework Only
 * @arr $_GET data
 * @return  String
 */
function get_value($fieldname, $default = null)
{
	$get =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	if (!empty($get[$fieldname])) {
		$val = $get[$fieldname];
		if (is_array($val)) {
			return implode(', ', $val);
		} else {
			return $val;
		}
	}
	return $default;
}

/**
 * Construct New Url With Current Url. Unset Query String if available
 * @param $arr_qs Array of New Query String Key Values
 * @return  string
 */
function unset_get_value($arr_qs, $page_path = null)
{
	$get =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	unset($get['request_uri']);
	if (is_array($arr_qs)) {
		foreach ($arr_qs as $key) {
			unset($get[$key]);
		}
	} else {
		unset($get[$arr_qs]);
	}
	$qs = null;
	if(!empty($get)){
		$qs = http_build_query($get);
	}
	
	if(!empty($page_path)){
		return $page_path . (!empty($qs) ? "?$qs" : null);
	}
	else{
		return Router::$page_url . (!empty($qs) ? "?$qs" : null);
	}
}

/**
 * Get Form Control POST BACK Value
 * @example <input value="<?php echo get_form_field_value('user_name'); ?>" />
 * @return  string
 */
function get_form_field_value($field, $default_value = null)
{
	$post =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	if (!empty($post[$field])) {
		return $post[$field];
	} else {
		return $default_value;
	}
}

/**
 * Get Form Radio || Checkbox Value On POST BACK
 * @example <input type="radio" <?php echo get_form_field_checked('gender','Male'); ?> />
 * @return  string
 */
function get_form_field_checked($field, $value)
{
	$post =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	if (!empty($post[$field]) && $post[$field] == $value) {
		return "checked";
	}
	return null;
}

function is_active_link($field, $value)
{
	$get =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	if (!empty($get[$field]) && $get[$field] == $value) {
		return "active";
	}
	return null;
}

/**
 * Set Full Address of a Path
 * @return  string
 */
function set_url($path = null)
{
	//check if is a valid url 
	if (filter_var($path, FILTER_VALIDATE_URL) !== FALSE) {
		return  $path;
	} else {
		return SITE_ADDR . $path;
	}
}

/**
 * Get number of files in a directory
 * @return  int
 */
function get_dir_file_count($dirpath)
{
	$filecount = 0;
	$files = glob($dirpath . "*");
	if ($files) {
		$filecount = count($files);
	}
	return $filecount;
}

/**
 * Format text by removing non letters characters with space.
 * @return  string
 */
function make_readable($string = '')
{
	if (!empty($string)) {
		$string = preg_replace("/[^a-zA-Z0-9]/", ' ', $string);
		$string = trim($string);
		$string = ucwords($string);
		$string = preg_replace('/\s+/', ' ', $string);
	}
	return $string;
}

/**
 * Print Out Full Address of a Link
 * @return null
 */
function print_link($link = "")
{
	
	//check if is a valid Link
	if (filter_var($link, FILTER_VALIDATE_URL) !== FALSE) {
		echo $link;
	} elseif(stripos($link, "tel:") === 0){ //check if link is telephone link
		echo  $link;
	}
	else{ //link must be a path.
		echo SITE_ADDR . $link;
	}
}
/**
 * Print out language translation of the default language
 * @return string
 */
function print_lang($name)
{
	global $lang;
	$phrase = $lang->get_phrase($name);
	if (!empty($phrase)) {
		echo $phrase;
	} else {
		echo $name;
	}
}

/**
 * Return language translation of the default language
 * @return string
 */
function get_lang($name)
{
	global $lang;
	$phrase = $lang->get_phrase($name);
	if (!empty($phrase)) {
		return $phrase;
	}
	return $name;
}


/**
 * Get The Current Url Address of The Application Server
 * @example http://mysitename.com
 * @return  string
 */
function get_url()
{
	$url  = isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
	$url .= '://' . $_SERVER['SERVER_NAME'];
	$url .= in_array($_SERVER['SERVER_PORT'], array('80', '443')) ? '' : ':' . $_SERVER['SERVER_PORT'];
	$url .= $_SERVER['REQUEST_URI'];
	return $url;
}

/**
 * Construct New Url With Current Url Or  New Query String and Path
 * @param $newqs Array of New Query String Key Values
 * @param $pagepath String
 * @return  string
 */
function set_page_link($pagepath = null, $newqs = array())
{
	$get =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	unset($get['request_uri']);
	$allget = array_merge($get, $newqs);
	$qs = null;
	if(!empty($allget)){
		$qs = http_build_query($allget);
	}
	if (empty($pagepath)) {
		return Router::$page_url . (!empty($qs) ? "?$qs" : null);
	}
	return "$pagepath"  . (!empty($qs) ? "?$qs" : null);
}

/**
 * Construct New Url With Current Url Or  New Query String
 * @param $newqs Array of New Query String Key Values
 * @param $replace String
 * @return  string
 */
function set_current_page_link($newqs = array(), $replace = false)
{
	$allqet = $newqs;
	if ($replace == false) {
		$get =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
		unset($get['request_uri']);
		$allqet = array_merge($get, $newqs);
	}
	$qs = null;
	if(!empty($allqet)){
		$qs = http_build_query($allqet);
	}
	return Router::$page_url . (!empty($qs) ? "?$qs" : null);
}

/**
 * Get Full Relative Path of The Current Page With Query String
 * @return  string
 */
function get_current_url()
{
	$get =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	unset($get['request_uri']);
	$qs = null;
	if(!empty($get)){
		$qs = http_build_query($get);
	}
	return Router::$page_url . (!empty($qs) ? "?$qs" : null);
}


/**
 * Set Msg that Will be Display to User in a Session. 
 * Can Be Displayed on Any View.
 * @return  object
 */
function set_flash_msg($msg, $type = "success", $dismissable = true, $showduration = 5000)
{
	if ($msg !== '') {
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
 * Display The Message Set In MsgFlash Session On Any Page
 * Will Clear The Message Afterwards
 * @return  null
 */
function show_flash_msg()
{
	$f = get_session("MsgFlash");
	if (!empty($f)) {
		echo $f;
		clear_session("MsgFlash");
	}
}

/**
 * Check if current browser platform is a mobile browser
 * Can Be Used to Switch Layouts and Views on A Mobile Platform
 * @return  object
 */
function is_mobile()
{
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function is_ajax()
{
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}
