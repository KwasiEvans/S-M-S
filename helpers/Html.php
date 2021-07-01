<?php

/**
 * Html Helper Class
 * Use To Display Customisable Html Page Component
 * Better used for small html reusable html components
 * @category  View Helper
 */
class Html
{
	/**
	 * Display Html Head Meta Tag
	 * @return Html
	 */
	public static function page_meta($name, $val = null)
	{
?>
		<meta name="<?php echo $name; ?>" content="<?php echo $val ?>" />
	<?php
	}

	/**
	 * Link To Css File From Css Dir
	 * NB -- Pass only The Css File Nam-- (eg. style.css) 
	 * @return Html
	 */
	public static function page_css($arg)
	{
	?>
		<link rel="stylesheet" href="<?php print_link(CSS_DIR . $arg); ?>" />
	<?php
	}

	/**
	 * Link To Js File From JS Dir
	 * NB -- Pass only The Js File Name-- (eg. script.js) 
	 * @return Html
	 */
	public static function page_js($arg)
	{
	?>
		<script type="text/javascript" src="<?php print_link(JS_DIR . $arg); ?>"></script>
		<?php
	}

	/**
	 * Build Menu List From Array
	 * Support Multi Level Dropdown Menu Tree
	 * Set Active Menu Base on The Current Page || url
	 * @return  HTML
	 */
	public static function render_menu($arrMenu, $menu_class = "nav navbar-nav", $menu_type = "dropdown")
	{
		$menu_link_class = "dropdown";
		$submenu_link_class = "dropdown-toggle";
		$data_toggle = "dropdown";
		$menu_group_id = "";
		if ($menu_type == "collapse" || $menu_type == "accordion") {
			$menu_link_class = "";
			$submenu_link_class = "dropdown-toggle";
			$data_toggle = "collapse";
			if ($menu_type == "accordion") {
				$menu_group_id = "menu-" . random_str();
			}
		}

		$page_name = Router::$page_name;
		$page_url = Router::$page_url;
		
		if (!empty($arrMenu)) {
		?>
			<ul id="<?php echo $menu_group_id; ?>" class="<?php echo $menu_class; ?>">
				<?php
				foreach ($arrMenu as $menuobj) {
					$path = $menuobj['path'];
					if (ACL::is_allowed($path)) {
						$active_class = null;
						$menu_url = parse_url($path, PHP_URL_PATH);
						if ($page_name == $menu_url || urldecode($page_url) == $menu_url) {
							$active_class = "active";
						}
						if (!empty($menuobj['submenu'])) {
							$menu_id = "";
							if($menu_type == "collapse" || $menu_type == "accordion"){
								$menu_id = "menu-" . random_str();
							}
				?>
							<li class="nav-item <?php echo $menu_link_class;  ?>">
								<a class="nav-link <?php echo $submenu_link_class;  ?>" href="#<?php echo $menu_id; ?>" data-boundary="viewport" data-toggle="<?php echo $data_toggle;  ?>">
									<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?>
									<span class="menu-label"><?php echo $menuobj['label']; ?></span>
								</a>
								<?php
								self::render_submenu($menuobj['submenu'], $menu_type, $menu_id, $menu_group_id);
								?>
							</li>
						<?php
						} else {
						?>
							<li class="nav-item">
								<a class="nav-link <?php echo ($active_class) ?>" href="<?php print_link($path); ?>">
									<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?>
									<span class="menu-label"><?php echo $menuobj['label']; ?></span>
								</a>
							</li>
				<?php
						}
					}
				}
				?>
			</ul>
		<?php
		}
	}

	/**
	 * Render Multi Level Dropdown menu 
	 * Recursive Function
	 * @return  HTML
	 */
	public static function render_submenu($arrMenu, $menu_type = "dropdown", $parent_id = null, $group_id = null)
	{
		$page_name = Router::$page_name;
		$page_url = Router::$page_url;

		$menu_class = "dropdown-menu";
		$submenu_class = "dropdown-submenu";
		$submenu_link_class = "dropdown-item dropdown-toggle";
		$menu_link_class = "dropdown-item";
		$data_toggle = "dropdown";
		$data_parent = "";
		if ($menu_type == "collapse" || $menu_type == "accordion") {
			$menu_class = "collapse";
			$submenu_class = "";
			$submenu_link_class = "nav-link dropdown-toggle";
			$menu_link_class = "nav-link";
			$data_toggle = "collapse";
			if ($menu_type == "accordion") {
				$data_parent = "data-parent='#$group_id'";
			}
		}

		if (!empty($arrMenu)) {
		?>
			<ul id="<?php echo $parent_id; ?>" class="<?php echo $menu_class ?> submenu list-unstyled" <?php echo $data_parent; ?>>
				<?php
				foreach ($arrMenu as $key => $menuobj) {
					$path = $menuobj['path'];
					if (ACL::is_allowed($path)) {
						$active_class = null;
						$menu_url = parse_url($path, PHP_URL_PATH);
						if ($page_url == $menu_url) {
							$active_class = "active";
						}

						if (!empty($menuobj['submenu'])) {
							$menu_id = "menu-" . random_str();
							//$parent_id = "menu-" . random_str();
				?>
							<li class="nav-item <?php echo $submenu_class;  ?>">
								<a class="<?php echo $submenu_link_class;  ?>" href="#<?php echo $menu_id; ?>" data-toggle="<?php echo $data_toggle;  ?>">
									<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?>

									<span class="menu-label"><?php echo $menuobj['label']; ?></span>
								</a>
								<?php self::render_submenu($menuobj['submenu'], $menu_type, $menu_id, $parent_id); ?>
							</li>
						<?php
						} else {
						?>
							<li class="nav-item">
								<a class="<?php echo $menu_link_class;  ?> <?php echo ($active_class) ?>" href="<?php print_link($path); ?>">
									<?php echo (!empty($menuobj['icon']) ? $menuobj['icon'] : null); ?>
									<span class="menu-label"><?php echo $menuobj['label']; ?></span>
								</a>
							</li>
				<?php
						}
					}
				}
				?>
			</ul>
			<?php
		}
	}

	/**
	 * generate cpatcha image and input control for form validation
	 * @return Html
	 */
	public static function captcha_field()
	{
		?>
		<div class="form-group d-flex">
			<div>
				<button type="button" data-captcha="<?php print_link("filehelper/captcha") ?>" class="btn btn-sm btn-light font-weight-bold">
					<img class="img-fluid" src="<?php print_link("filehelper/captcha") ?>" />
				</button>
			</div>
			<div>
				<input class="form-control" required="" placeholder="Enter the code" name="form_captcha_code"  />
			</div>
		</div>
	<?php
	}

	/**
	 * generate cpatcha image and input control for form validation
	 * @return Html
	 */
	public static function ajaxpage_spinner()
	{
		?>
		<div class="ajax-page-load-indicator" style="display:none">
			<div class="text-center d-flex justify-content-center load-indicator">
				<span class="loader mr-3"></span>
				<span class="font-weight-bold">Loading...</span>
			</div>
		</div>
		<?php
	}

	/**
	 * generate cpatcha image and input control for form validation
	 * @return Html
	 */
	public static function csrf_token()
	{
		?>
		<input type="hidden" name="csrf_token" value="<?php echo Csrf::$token; ?>" />
	<?php
	}

	/**
	 * Display Html Image Tag
	 * Can be Use to Display Multiple Images Separated By Comma
	 * Also Can Be Use To Resize Image Via Url
	 * @return Html
	 */
	public static function page_img($imgsrc, $resizewidth = null, $resizeheight = null, $max = 1, $link = null, $class = null)
	{
		if (!empty($imgsrc)) {
			$arrsrc = explode(",", $imgsrc);
			if ($max >= 1) {
				$arrsrc = array_slice($arrsrc, 0, min(count($arrsrc), $max));
			}
			foreach ($arrsrc as $src) {
				$imgpath = "helpers/timthumb.php?src=$src";
				$imgpath .= ($resizeheight != null ? "&h=$resizeheight" : null);
				$imgpath .= ($resizewidth != null ? "&w=$resizewidth" : null);
				$previewlink = $link;
				$previewattr = null;
				if ($link == null) {
					$previewlink = "helpers/timthumb.php?src=$src&w=760&h=520";
					$previewattr = 'data-gallery=""';
				}
			?>
				<a <?php echo $previewattr; ?> href="<?php print_link($previewlink) ?>">
					<img <?php echo ($class != null ? 'class="' . $class . '"' : null) ?> src="<?php print_link($imgpath); ?>" />
				</a>
		<?php
			}
		}
	}

	/**
	 * display star rating
	 * @return Html
	 */
	public static function star_rating($value, $num_star = 5)
	{
		?>
		<div class="star-rating">
			<?php
				for ($i = 1; $i <= $num_star; $i++) {
					$active = ($i <= $value ? "active" : null);
				?>
					<span class="star <?php echo $active ?>"></span>
				<?php
				}
			?>
		</div>
	<?php
	}

	/**
	 * display star rating
	 * @return Html
	 */
	public static function progress_bar($value, $max_value = 100, $class = "")
	{
		$percent = ($value / $max_value * 100);
	?>
		<div class="progress has-tooltip" title="<?php echo $value; ?>"  style="height: 15px;">
			<div class="progress-bar <?php echo $class; ?>" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="<?php echo $max_value; ?>">
				<span class="progress-label"><?php echo round($percent,2); ?>%</span>
			</div>
		</div>
	<?php
	}

	/**
	 * display star rating
	 * @return Html
	 */
	public static function check_button($value, $check_value = "true")
	{
		$checked = (strtolower($value) == strtolower($check_value) ? "checked" : null);
	?>
		<div class="td-check-button <?php echo $checked ?>">
			<i class="material-icons">check_circle</i>
		</div>
		<?php
	}

	/**
	 * display multiple file link (files can be separated by comma)
	 * @return Html
	 */
	public static function page_link_file($src, $btnclass = "btn btn-info btn-sm", $target = "_blank")
	{
		if (!empty($src)) {
			$arrpath = explode(",", $src);
			foreach ($arrpath as $path) {
				if (!empty($path)) {
		?>
					<a class="<?php echo $btnclass ?>" target="<?php echo $target ?>" href="<?php print_link($path); ?>">
						<i class="material-icons">attachment</i>
						<?php echo basename($path); ?>
					</a>
			<?php
				}
			}
		}
	}

	/**
	 * Display html Hyper Link Tag
	 * If User is Allowed to Assess That Particular Resource Or link
	 * @return Html
	 */
	public static function secured_page_link($path, $label = "", $class = null, $attrs = null)
	{
		if (ACL::is_allowed($path)) {
			?>
			<a href="<?php print_link($path); ?>" class="<?php echo ($class) ?>" <?php echo $attrs; ?>><?php echo ($label) ?></a>
		<?php
		}
	}

	/**
	 * Display html Hyper Link Tag
	 * @return Html
	 */
	public static function page_link($path, $label = "", $classes = null, $attrs = null)
	{
		?>
		<a href="<?php print_link($path); ?>" class="<?php echo ($classes) ?>" <?php echo $attrs; ?>><?php echo ($label) ?></a>
	<?php
	}

	/**
	 * Display import data form
	 * @return Html
	 */
	public static function import_form($form_path, $button_text = "", $format_text = "csv, json")
	{
	?>
		<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#-import-data">
			<i class="material-icons">insert_drive_file</i> <?php echo $button_text; ?>
		</button>

		<form method="post" action="<?php print_link($form_path) ?>" enctype="multipart/form-data" id="-import-data" class="modal fade" role="dialog" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Import Data</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<label>Select a file to import <input required="required" class="form-control form-control-sm" type="file" name="file" /> </label>
						<small class="text-muted">Supported file types(csv , json)</small>

					</div>
					<div class="modal-footer">
						<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Import Data</button>
					</div>
				</div>
			</div>
		</form>
	<?php
	}



	/**
	 * Convinient Function For Diisplaying Field Order By
	 * Uses The Current Page URL and Modify Only The orderby and ordertype query string Parameter
	 * @return Html
	 */
	public static function get_field_order_link($fieldname, $fieldlabel)
	{

		$currentordertype = strtoupper(get_value("ordertype", "ASC"));
		$newordertype = ($currentordertype == 'ASC' ? 'DESC' : 'ASC');
		$orderlink = set_current_page_link(array("orderby" => $fieldname, "ordertype" => $newordertype));
		$linkbtnclass = (get_value('orderby') == $fieldname ? 'active' : '');
	?>
		<a class="th-sort-link <?php echo $linkbtnclass; ?>" data-orderby="<?php echo $fieldname;  ?>" href="<?php print_link($orderlink); ?>">
			<?php echo $fieldlabel; ?>
		</a>
		<?php
		if ($currentordertype == 'DESC' && get_value('orderby') == $fieldname) {
		?>
			<span class="sort-icon dropdown-toggle"></span>	<!-- <i class="material-icons">arrow_drop_up</i> -->
		<?php
		} else {
		?>
			<span class="sort-icon dropdown-toggle inverse text-muted"></span> <!-- <i class="material-icons">arrow_drop_down</i> -->
		<?php
		}
		?>
	<?php
	}


	/**
	 * Convinient Function For Diisplaying Field Order By
	 * Uses The Current Page URL and Modify Only The orderby and ordertype query string Parameter
	 * @return Html
	 */
	public static function uploaded_files_list($files, $inputid, $delete_file = "false")
	{
	?>
		<div class="uploaded-file-holder clearfix">
			<?php
			if (!empty($files)) {
				$arrsrc = explode(",", $files);
				$i = 0;
				$img_exts =  array('gif', 'png', 'jpg');

				foreach ($arrsrc as $src) {
					$i++;
					$previewattr = "";
					$is_img = false;
					$ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
					if (in_array($ext, $img_exts)) {

						$is_img = true;
					}

			?>
					<div class="d-inline-block p-2 card m-1" id="file-holder-<?php echo $i; ?>">
						<?php
						if ($is_img) {
							self::page_img($src, 50, 50);
							echo basename($src);
						} else {
						?>
							<a class="btn btn-sm btn-light" target="_blank" href="<?php print_link($src) ?>">
								<?php echo basename($src); ?>
							</a>
						<?php
						}
						?>
						<button data-input="<?php echo $inputid; ?>" data-delete-file="<?php echo $delete_file; ?>" type="button" data-file="<?php echo $src ?>" data-file-num="<?php echo $i; ?>" class="btn btn-sm btn-danger removeEditUploadFile">
							&times;
						</button>
					</div>
			<?php
				}
			}
			?>
		</div>
		<?php
	}

	public static function display_form_errors($formerror)
	{
		if (!empty($formerror)) {
			if (!is_array($formerror)) {
		?>
				<div class="alert alert-danger animated shake">
					<?php echo $formerror; ?>
				</div>
			<?php
			} else {
			?>
				<script>
					$(document).ready(function() {
						<?php
						foreach ($formerror as $key => $value) {
							echo "$('[name=$key]').parent().addClass('has-error').append('<span class=\"help-block\">$value</span>');";
						}
						?>
					});
				</script>
<?php
			}
		}
	}
}
