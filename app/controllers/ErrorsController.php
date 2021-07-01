<?php
/**
 * Info Contoller Class
 * @category  Controller
 */

class ErrorsController extends BaseController{

	/**
     * Display forbidden error page
     * @return Html View
     */
	function forbidden(){
		$this->render_view("errors/forbidden.php");
	}
}
