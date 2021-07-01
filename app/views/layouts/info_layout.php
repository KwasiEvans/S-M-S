<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" href="<?php print_link(SITE_FAVICON); ?>" />
		<title><?php echo $this->get_page_title();; ?></title>
		<?php 
			Html ::  page_meta('theme-color',META_THEME_COLOR);
			Html ::  page_meta('author',META_AUTHOR); 
			Html ::  page_meta('keyword',META_KEYWORDS); 
			Html ::  page_meta('description',META_DESCRIPTION); 
			Html ::  page_meta('viewport',META_VIEWPORT);
			Html ::  page_css('material-icons.css');
			Html ::  page_css('animate.css');
		?>
				<?php 
			Html ::  page_css('bootstrap-default.css');
			Html ::  page_css('bootstrap-theme-minco.css');
			Html ::  page_css('custom-style.css');
		?>
		<?php
			Html ::  page_js('jquery-3.3.1.min.js');
		?>
		<style>
			#main-content{
				padding:0;
				min-height:500px;
			}
		</style>
	</head>
	<body style="padding-top:50px;">
		<nav class="navbar navbar-expand-lg bg-info navbar-light fixed-top">
			<a class="navbar-brand" href="<?php print_link('') ?>">
				<img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> 
				<?php echo SITE_NAME ?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link(HOME_PAGE) ?>">Home</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('info/about') ?>">About us</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('info/help') ?>">Help and FAQ</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="<?php print_link('info/contact') ?>">Contact us</a>
					</li>
				</ul>
			</div>
		</nav>
		<div id="main-content" class="mt-4">
			<div id="page-content">
				<?php $this->render_body();?>
			</div>
			<?php 
				$this->render_view('appfooter.php'); 
			?>
		</div>
		<?php 
			Html ::  page_js('popper.js');
			Html ::  page_js('bootstrap-4.3.1.min.js');
		?>
	</body>
</html>