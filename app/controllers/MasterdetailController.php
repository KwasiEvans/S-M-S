<?php
/**
 * Display master detail pages
 * @return View
 */
class MasterdetailController extends SecureController
{
	function index($master_page, $detail_page, $field_name = null, $field_value = null)
	{
		$view_data = array(
			"master_page" => $master_page,
			"detail_page" => $detail_page,
			"field_name" => $field_name,
			"field_value" => $field_value
		);
		$this->render_view("$master_page/$detail_page-pages.php", $view_data);
	}
}