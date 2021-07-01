<?php
/**
 * Page Access Control
 * @category  RBAC Helper
 */
defined('ROOT') or exit('No direct script access allowed');
class ACL
{
	

	/**
	 * Array of user roles and page access 
	 * Use "*" to grant all access right to particular user role
	 * @var array
	 */
	public static $role_pages = array(
			'headteacher' =>
						array(
							'users' => array('list','view','userregister','accountedit','accountview','add','edit', 'editfield','delete','import_data'),
							'admission' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'announcement' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'feestracture' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'apply_for_admission' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'assignment' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'event' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'enrolment' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'perfomance' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'how_to_make_payment' => array('list','view','add','edit', 'editfield','delete')
						),
		
			'pupils' =>
						array(
							'announcement' => array('list','view'),
							'feestracture' => array('list','view'),
							'apply_for_admission' => array('list','add'),
							'assignment' => array('list','view'),
							'event' => array('list','view'),
							'how_to_make_payment' => array('list','add')
						)
		);

	/**
	 * Current user role name
	 * @var string
	 */
	public static $user_role = null;

	/**
	 * pages to Exclude From Access Validation Check
	 * @var array
	 */
	public static $exclude_page_check = array("", "index", "home", "account", "info", "masterdetail");

	/**
	 * Init page properties
	 */
	public function __construct()
	{	
		if(!empty(USER_ROLE)){
			self::$user_role = USER_ROLE;
		}
	}

	/**
	 * Check page path against user role permissions
	 * if user has access return AUTHORIZED
	 * if user has NO access return UNAUTHORIZED
	 * if user has NO role return NO_ROLE
	 * @return string
	 */
	public static function GetPageAccess($path)
	{
		$rp = self::$role_pages;
		if ($rp == "*") {
			return AUTHORIZED; // Grant access to any user
		} else {
			$path = strtolower(trim($path, '/'));

			$arr_path = explode("/", $path);
			$page = strtolower($arr_path[0]);

			//If user is accessing excluded access contrl pages
			if (in_array($page, self::$exclude_page_check)) {
				return AUTHORIZED;
			}

			$user_role = strtolower(USER_ROLE); // Get user defined role from session value
			if (array_key_exists($user_role, $rp)) {
				$action = (!empty($arr_path[1]) ? $arr_path[1] : "list");
				if ($action == "index") {
					$action = "list";
				}
				//Check if user have access to all pages or user have access to all page actions
				if ($rp[$user_role] == "*" || (!empty($rp[$user_role][$page]) && $rp[$user_role][$page] == "*")) {
					return AUTHORIZED;
				} else {
					if (!empty($rp[$user_role][$page]) && in_array($action, $rp[$user_role][$page])) {
						return AUTHORIZED;
					}
				}
				return FORBIDDEN;
			} else {
				//User does not have any role.
				return NOROLE;
			}
		}
	}

	/**
	 * Check if user role has access to a page
	 * @return Bool
	 */
	public static function is_allowed($path)
	{
		return (self::GetPageAccess($path) == AUTHORIZED);
	}

}
