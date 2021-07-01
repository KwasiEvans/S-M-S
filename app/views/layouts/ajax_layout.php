<?php
	// Set url variable from router class
	$page_name = Router::$page_name;
	$page_action = Router::$page_action;
	$page_id = Router::$page_id;
	$this->render_body();
	//rebind jquery plugins
	Html :: page_js("plugins-init.js");
?>