<?php
	// Set url Variable From Router Class
	$page_name = Router::$page_name;
	$page_action = Router::$page_action;
	$page_id = Router::$page_id;
	$body_class = "$page_name-" . str_ireplace('list','index', $page_action);
	$page_title = $this->get_page_title();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="shortcut icon" href="<?php print_link(SITE_FAVICON); ?>" />
		<?php 
			Html ::  page_meta('theme-color',META_THEME_COLOR);
			Html ::  page_meta('author',META_AUTHOR); 
			Html ::  page_meta('keyword',META_KEYWORDS); 
			Html ::  page_meta('description',META_DESCRIPTION); 
			Html ::  page_meta('viewport',META_VIEWPORT);
			Html ::  page_css('material-icons.css');
			Html ::  page_css('animate.css');
			Html ::  page_css('blueimp-gallery.css');
		?>
				<?php 
			Html ::  page_css('bootstrap-default.css');
			Html ::  page_css('bootstrap-theme-minco.css');
			Html ::  page_css('custom-style.css');
		?>
		<?php
			Html ::  page_css('flatpickr.min.css');
			Html::page_css('summernote.min.css');
			Html ::  page_css('bootstrap-editable.css');
			Html ::  page_css('dropzone.min.css');
			Html ::  page_js('jquery-3.3.1.min.js');
			Html::page_js('chartjs-2.3.0.js');
		?>
	</head>
	<?php 
		$page_id = "index";
		if(user_login_status() == true){
			$page_id = "main";
		}
	?>
	<body id="<?php echo $page_id ?>" class="with-login <?php echo $body_class ?>">
		<div id="page-wrapper">
			<!-- Show progress bar when ajax upload-->
			<div class="progress ajax-progress-bar">
				<div class="progress-bar"></div>
			</div>
			<?php 
				$this->render_view('appheader.php'); 
			?>
			<div id="main-content">
				<!-- Page Main Content Start -->
					<div id="page-content">
						<?php $this->render_body();?>
					</div>	
				<!-- Page Main Content [End] -->
				<!-- Page Footer Start -->
					<?php 
						$this->render_view('appfooter.php'); 
					?>
				<!-- Page Footer Ends -->
				<div class="flash-msg-container"><?php show_flash_msg(); ?></div>
				<!-- Modal page for displaying ajax page -->
				<div id="main-page-modal" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-body p-0 reset-grids inline-page">
							</div>
							<div style="top: 5px; right:5px; z-index: 999;" class="position-absolute">
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">&times;</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal page for displaying record delete prompt -->
				<div class="modal fade" id="delete-record-modal-confirm" tabindex="-1" role="dialog" aria-labelledby="delete-record-modal-confirm" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Delete record</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
									<span aria-hidden="true">&times;</span> 
								</button>
							</div>
							<div id="delete-record-modal-msg" class="modal-body"></div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<a href="" id="delete-record-modal-btn" class="btn btn-primary">Delete</a> 
							</div>
						</div>
					</div>
				</div>
				<!-- Image Preview Component [Start] -->
				<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
					<div class="slides"></div>
					<h3 class="title"></h3>
					<a class="prev">‹</a>
					<a class="next">›</a>
					<a class="close">×</a>
					<a class="play-pause"></a>
					<ol class="indicator"></ol>
				</div>
				<!-- Image Preview Component [End] -->
				<template id="page-loading-indicator">
					<div class="p-2 text-center m-2 text-muted m-auto">
						<div class="ajax-loader"></div>
						<h4 class="p-3 mt-2 font-weight-light">Loading...</h4>
					</div>
				</template>
				<template id="page-saving-indicator">
					<div class="p-2 text-center m-2 text-muted">
						<div class="lds-dual-ring"></div>
						<h4 class="p-3 mt-2 font-weight-light">Saving...</h4>
					</div>
				</template>
				<template id="inline-loading-indicator">
					<div class="p-2 text-center d-flex justify-content-center">
						<span class="loader mr-3"></span>
						<span class="font-weight-bold">Loading...</span>
					</div>
				</template>
			</div>
		</div>
		<script>
			var siteAddr = '<?php echo SITE_ADDR; ?>';
			var defaultPageLimit = <?php echo MAX_RECORD_COUNT; ?>;
			var csrfToken = '<?php echo Csrf :: $token; ?>';
		</script>
		<?php 
			Html ::  page_js('popper.js');
			Html ::  page_js('bootstrap-4.3.1.min.js');
		?>
		<?php
			Html ::  page_js('flatpickr.min.js');
			Html::page_js('summernote.min.js');
			Html ::  page_js('bootstrap-editable.js');
			Html ::  page_js('dropzone.min.js');
			Html ::  page_js('plugins.js'); //boostrapswitch, passwordStrength, twbs-pagination, blueimp-gallery,
			Html ::  page_js('plugins-init.js');
			Html ::  page_js('page-scripts.js');
		?>
	</body>
</html>