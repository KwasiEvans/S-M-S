<?php
defined('ROOT') or exit('No direct script access allowed');
use Dompdf\Dompdf;

/**
 * Application Base View
 */
class BaseView
{
	/**
	 * Data Passed From Controller to the View
	 * Can Be Access By All Other Sub View in The Page
	 * @var  object
	 */
	public $model = null;

	/**
	 * Reference to the current route class
	 * Provide acccess to route properties
	 * @var Router
	*/
	public $route = null;


	/**
	 * Render Page In Following Format [html | json | xml | csv | pdf | word | excel | image]
	 * Can Be Pass Via Query String
	 * @var  string
	 */
	public $format = "html";

	/**
	 * Current page limit count
	 * @var  int
	 */
	public $limit_count = MAX_RECORD_COUNT;
	
	/**
	 * Current page number
	 * @var  int
	 */
	public $limit_start = 1;

	/**
	 * Render link tags from the report page
	 * Only for pdf and word export
	 * @var  bool
	 */
	public $report_links = true;
	/**
	 * Include page record sequnce if available
	 * Only for word and pdf export
	 * @var bool
	 */
	public $report_list_sequence = true;
	/**
	 * File name which the report will be saved
	 * No extension needed.
	 * @var string
	 */
	public $report_filename = "report";
	/**
	 * The report title
	 * @var string
	 */
	public $report_title = "";
	/**
	 * Layout file which the report will be rendered into
	 * @var string
	 */
	public $report_layout = "report_layout.php";
	/**
	 * Set the report orientation layout
	 * only for pdf export
	 * supported values (portrait,landscape)
	 * @var string
	 */
	public $report_orientation = "portrait";
	/**
	 * Set the report paper size
	 * Only for  pdf export
	 * supported values (A4,Letter,Legal)
	 * @var string
	 */
	public $report_paper_size = "A4";

	/**
	 * Record fields which will not be exported
	 * Example array('date_posted', 'taxes', 'id')
	 * @var array
	 */
	public $report_hidden_fields = array();

	/**
	 * Set Page Title From The Controller
	 * @var string
	 */
	public $page_title = null;

	/**
	 * View Title
	 * @var bool
	 */
	public $view_title = null;

	/**
	 * Model Data passed From Controller to The View
	 * @var string
	 */
	public $redirect_to = null;

	/**
	 * Model Data passed From Controller to The View
	 * @var string
	 */
	public $view_data = null;

	/**
	 * $_GET which is used to set default values for form fields. 
	 * can be passed from other pages
	 * @var array
	 */
	public $form_data = null;

	/**
	 * Page Properties passed from other Views to The current page
	 * @var array
	 */
	public $page_props = null;

	/**
	 * Show Page Header Component
	 * @var boolean
	 */
	public $show_header = true;

	/**
	 * Show Page Footer Components
	 * @var boolean
	 */
	public $show_footer = true;

	/**
	 * Show Search Control
	 * @var bool
	 */
	public $show_search = true;

	/**
	 * Show Edit Record Button
	 * @var bool
	 */
	public $show_edit_btn = true;

	/**
	 * Show View Record Button
	 * @var bool
	 */
	public $show_view_btn = true;

	/**
	 * Show Delete Button Component
	 * @var bool
	 */
	public $show_delete_btn = true;

	/**
	 * Show Delete All Button 
	 * @var bool
	 */
	public $show_multi_delete_btn = true;

	/**
	 * Include Import Records Button
	 * @var bool
	 */
	public $show_import_btn = true;

	/**
	 * Include Export Button
	 * @var bool
	 */
	public $show_export_btn = true;

	/**
	 * Show Record Selection Checkbox
	 * @var bool
	 */
	public $show_checkbox = true;

	/**
	 * Show Record List Number
	 * @var bool
	 */
	public $show_list_sequence = true;


	/**
	 * Show Pagination Component
	 * @var bool
	 */
	public $show_pagination = true;

	/**
	 * The view template use to render the page data
	 * @var string
	 */
	public $view_name = null;
	
	/**
	 * The view template use to render the page data when request is ajax
	 * @var string
	 */
	public $ajax_view = null;


	/**
	 * Page Error Passed From Controller to The View
	 * @var string,array
	 */
	public $page_error = null;

	/**
	 * Form Validation Error Passed From Controller to The View
	 * @var string,array
	 */
	public $form_error = null;

	/**
	 * Whether to Render View as a Partial View Without The Layout
	 * @var boolean
	 */
	public $is_partial_view = false;

	/**
	 * The Relative Path of Partial View File
	 * @var string
	 */
	public $partial_view = null;

	/**
	 * The html view use to render ajax dropdown searched content
	 * @var string
	 */
	public $search_template = null;
	
	/**
	 * The html view use to render ajax content
	 * @var string
	 */
	public $ajax_page = null;



	/**
	 * The Relative Path of Partial View File
	 * @var string
	 */
	public $force_layout = null;
	
	/**
	 * Show print dialog after the page load
	 * @var boolean
	 */
	public $force_print = false;


	

	function __construct($arg = null)
	{
		// Pass All Query String Data to the View.
		$get = $this->form_data =  filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);;
		if (!empty($get)) {
			foreach ($get as $obj => $val) {
				$this->$obj = $val;
			}
		}
	}

	/**
	 * Render Page From The Controller 
	 * @return null
	 */
	public function render($view_name = null, $view_data = null, $layout = "main_layout.php")
	{
		$this->view_name = $view_name;
		//passed data from controller to view
		$this->view_data = $view_data;
		$page_format = strtolower($this->format);
		if ($page_format == "print") {
			$this->force_print = true;
			$report_body = $this->parse_report_html(); //get exportable content
			echo $report_body;
			return;
		} 
		elseif ($page_format == "pdf") {
			$report_body = $this->parse_report_html(); //get exportable content
			$filename = $this->report_filename;
			$dompdf = new Dompdf();
			$dompdf->loadHtml($report_body);
			$dompdf->set_option('isRemoteEnabled', true); //allow to display external images
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper($this->report_paper_size, $this->report_orientation);
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream("$filename.pdf");
			return;
		} 
		elseif ($page_format == "word") {
			$report_body = $this->parse_report_html(); //get exportable content
			$filename = $this->report_filename;
			$htd = new Html2Doc();
			$htd->createDoc($report_body, "$filename.doc", true); //create and force download of the document
			return;
		} elseif ($page_format == "json") {
			$report_data = $this->parse_report_records(); //get exportable content
			return render_json($report_data);
		} elseif ($page_format == "csv") {
			$records = $this->parse_report_records(); //get exportable records
			$csv_data = arr_to_csv($records);
			$filename = $this->report_filename;
			header("Content-Disposition: attachment; filename=$filename.csv");
			header('Content-Type: text/plain'); // Don't use application/force-download - it's not a real MIME type, and the Content-Disposition header is sufficient
			header('Content-Length: ' . strlen($csv_data));
			header('Connection: close');
			echo $csv_data;
			return;
		} elseif ($page_format == "excel") {
			/* https://github.com/mk-j/PHP_XLSXWriter
			Lightwight XLSX Excel Spreadsheet Writer in PHP
			This library is designed to be lightweight, and have minimal memory usage.
			 */
			$filename = $this->report_filename . ".xlsx";
			$sheet_name = $this->report_title;
			//excel headers
			header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			$records = $this->parse_report_records(); //get exportable records
			//Simple/Advanced Cell Formats:
			/* $header = array(
				'created'=>'date',
				'product_id'=>'integer',
				'quantity'=>'#,##0',
				'amount'=>'price',
				'description'=>'string',
				'tax'=>'[$$-1009]#,##0.00;[RED]-[$$-1009]#,##0.00',
			  ); */
			$arr_titles = array_keys(current($records));// get the table header from the record.
			$headers = array_fill_keys($arr_titles, 'string'); //setting all headers to cell type of string

			$writer = new XLSXWriter();
			$writer->setAuthor(SITE_NAME);
			$writer->writeSheetHeader($sheet_name, $headers);
			foreach ($records as $row) {
				$writer->writeSheetRow($sheet_name, $row);
			}
			$writer->writeToStdOut();
			//$writer->writeToFile('example.xlsx');//to save locally
			//echo $writer->writeToString();//to output to a variable
			return;
		}

		//continue to render page on the browser 
		if (is_ajax()){
			if(!empty($this->search_template) && file_exists(PAGES_DIR . $this->search_template)){
				include(PAGES_DIR . $this->search_template);
			}
			else{
				include(LAYOUTS_DIR . "ajax_layout.php"); 
			}
		}
		elseif (!empty($layout) && $this->is_partial_view == false) {
			// If force_layout is set, then use the layout.
			// force layout can be set to render a view with different layout from another controller or view.
			if (!empty($this->force_layout)) {
				$layout = $this->force_layout;
			}

			if (file_exists(LAYOUTS_DIR . $layout)) {
				include(LAYOUTS_DIR . $layout);
			} else {
				echo "The Layout Does not Exit;";
			}
		} 
		else {
			/* //Do not Include Layout if Render as a Partial View in another View
				use the partial_view if it's set
				Get View name from current page url if not passed from controller 
			*/
			if (!empty($this->partial_view)) {
				$view_name = $this->partial_view;
			} else if (empty($view_name)) {
				$view_name = Router::$page_name . "/" . Router::$page_action . ".php";
			}
			if (file_exists(PAGES_DIR . $view_name)) {
				include(PAGES_DIR . $view_name);
			} else {
				print_r($view_name);
			}
		}
		return $this;
	}


	/**
	 * Render Main Page from the Controller onto the Layout
	 * @return null
	 */
	protected function render_body()
	{
		$view = PAGES_DIR . $this->view_name;
		if (file_exists($view)) {
			include($view);
		} else {
			echo "$view File Not Found";
		}
	}

	/**
	 * Include View Onto A Page as A Partial View 
	 * @example $this->render_view("components/bar_chart.php");
	 * @return null
	 */
	protected function render_view($viewname, $args = null)
	{
		$this->view_args = $args;
		$view = PAGES_DIR . $viewname;
		if (file_exists($view)) {
			include($view);
		} else {
			echo "$view File  Not Found";
		}
	}


	/**
	 * Render Page as a Partial View Onto Another Page Using Url Parameters
	 * @example call inside any view or layout 
	 * $this->render_page("users/index/status/active/?limit_start=1&limit_count=5&orderby=user_id&ordertype=desc");
	 * @return null
	 */
	protected function render_page($url, $page_props = null, $view_path = null)
	{
		if ($this->format == "html"){
			$qs = parse_url($url, PHP_URL_QUERY);
			parse_str($qs, $get);
			$request = array();
			if (!empty($get)) { //build new $_GET array from the url query string 
				foreach ($get as $key => $val) {
					$request[$key] = $val;
				}
			}
			$path = parse_url($url, PHP_URL_PATH); // Get Path from URL
			//Dispatch as new page
			$router = new Router;
			$router->request = $request;
			$router->is_partial_view = true;
			$router->page_props = $page_props;
			$router->partial_view = $view_path;
			$router->run($path);
		}
	}

	/**
	 * Construct New Url With Current Url Or  New Query String
	 * @param $newqs Array of New Query String Key Values
	 * @param $replace String
	 * @return  string
	 */
	function set_current_page_link($newqs = array(), $replace = false)
	{
		$all_get = $newqs;
		$link = $this->route->page_url;
		if ($replace == false) {
			$request = $this->route->request;
			$get = (array) $request;
			unset($get['request_uri']);
			$all_get = array_merge($get, $newqs);
		}
		$qs = null;
		if(!empty($all_get)){
			$qs = http_build_query($all_get);
			$link .= "?$qs";
		}
		return $link;
	}

	/**
	 * Get Form Input Value On POST BACK
	 * @example <input type="radio" <?php echo set_field_value('gender','Male'); ?> />
	 * @return  string
	 */
	public function set_field_value($fieldname, $default_value = null, $index = null)
	{
		$post =  filter_var_array($_REQUEST, FILTER_SANITIZE_STRING);
		if (!empty($this->page_props[$fieldname])) {
			return $this->page_props[$fieldname];
		} elseif (!empty($post[$fieldname])) {
			if ($index === null) {
				return $post[$fieldname];
			} else {
				return $post["row$index"][$fieldname];
			}
		} else {
			return $default_value;
		}
	}

	/**
	 * Get Form Radio || Checkbox Value On POST BACK
	 * @example <input type="radio" <?php echo set_field_checked('gender','Male'); ?> />
	 * @return  string
	 */
	public function set_field_checked($fieldname, $value, $default_value = null)
	{
		$post =  filter_var_array($_REQUEST, FILTER_SANITIZE_STRING);
		$req_val = null;
		if (!empty($this->page_props[$fieldname])) {
			$req_val = $this->page_props[$fieldname];
		} elseif (!empty($post[$fieldname])) {
			$req_val = $post[$fieldname];
		} else {
			$req_val = $default_value;
		}

		if (!empty($req_val)) {
			if (is_array($req_val)) {
				return (in_array($value, $req_val) ? 'checked' : null);
			} elseif ($req_val == $value) {
				return "checked";
			}
		}
		return null;
	}

	/**
	 * Get Form Radio || Checkbox Value On POST BACK
	 * @example <input type="radio" <?php echo set_field_selected('gender','Male'); ?> />
	 * @return  string
	 */
	public function set_field_selected($fieldname, $value, $default_value = 0)
	{
		$post =  filter_var_array($_REQUEST, FILTER_SANITIZE_STRING);
		$req_val = null;
		if (!empty($this->page_props[$fieldname])) {
			$req_val = $this->page_props[$fieldname];
		} elseif (!empty($post[$fieldname])) {
			$req_val = $post[$fieldname];
		} else {
			$req_val = $default_value;
		}
		if (!empty($req_val)) {
			if (is_array($req_val)) {
				return (in_array($value, $req_val) ? 'selected' : null);
			} elseif ($req_val == $value) {
				return "selected";
			}
		}
		return null;
	}

	/**
	 * Get Form Checkbox Check Status On POST BACK
	 * For a multi input /select control
	 * @example <input type="checkbox" <?php echo check_form_field_checked('roles'); ?> />
	 * @return  string
	 */
	public function check_form_field_checked($srcdata, $value)
	{
		if (!empty($srcdata)) {
			$arr = explode(",", $srcdata);
			if (in_array($value, $arr)) {
				return "checked";
			}
		}
		return null;
	}

	/**
	 * Display Html Head Title
	 * Set Title From Url If Present
	 * @return Html
	 */
	public function get_page_title($title = null)
	{
		//title passed to the page view
		if (!empty($this->page_title)) {
			$title = $this->page_title;
		} else {
			$title = Router::$page_name;
		}
		return $title;
	}

	/**
	 * Display page errors passed from the controller to the view
	 * Can be single string or array
	 * @return Html
	 */
	public function display_page_errors()
	{
		$page_errors = $this->page_error;
		if (!empty($page_errors)) {
			if (!is_array($page_errors)) {
?>
				<div class="alert alert-danger animated shake">
					<?php echo $page_errors; ?>
				</div>
				<?php
			} else {
				foreach ($page_errors as $error) {
				?>
					<div class="alert alert-danger animated shake">
						<?php echo $error; ?>
					</div>
<?php
				}
			}
		}
	}

	/**
	 * Process the rendered page report and return the exportable content
	 * Remove unwanted element from the export content
	 * @return string
	 */
	private function parse_report_html()
	{
		ob_start();
		include(LAYOUTS_DIR . $this->report_layout); //render page content as html into a variable
		$page_html = ob_get_contents();
		ob_end_clean();
		// fix ampersand and angle brackets
		// decode HTML entity
		$page_html = str_replace(array('&lt;', '&gt;', '&amp;'), array('_lt_', '_gt_', '_amp_'), $page_html);
		$page_html = html_entity_decode($page_html, ENT_QUOTES, 'UTF-8');
		$page_html = str_replace('&', '&amp;', $page_html);
		$page_html = str_replace(array('_lt_', '_gt_', '_amp_'), array('&lt;', '&gt;', '&amp;'), $page_html);
		// Load DOM
		$orignalLibEntityLoader = libxml_disable_entity_loader(true);
		$doc = new \DOMDocument();
		@$doc->loadHTML($page_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOEMPTYTAG);
		libxml_disable_entity_loader($orignalLibEntityLoader);
		//extract only the report part
		$page_body = $doc->getElementById("page-report-body");
		if (!empty($page_body)) {
			$xpath = new DOMXPath($page_body->ownerDocument);
			$hide_columns = 'contains(attribute::class, "td-btn") or contains(attribute::class, "td-checkbox")';
			if (!$this->report_list_sequence) {
				$hide_columns .= ' or contains(attribute::class, "td-sno")';
			}
			if (!empty($this->report_hidden_fields)) {
				foreach ($this->report_hidden_fields as $fieldname) {
					$hide_columns .= " or contains(attribute::class, 'td-$fieldname')";
				}
			}
			$hide_columns = "//*[$hide_columns]";
			//remove the unwanted table cell
			$remove_tags = $xpath->query($hide_columns);
			if (!empty($remove_tags)) {
				foreach ($remove_tags as $e) {
					$e->parentNode->removeChild($e); // Delete this node
				}
			}
			if ($this->report_links == true) {
				//this will remove the href from the links
				$links = $xpath->query("//td/a");
				if (!empty($links)) {
					foreach ($links as $link) {
						$link->removeAttribute('href'); //remove link href attribute
					}
				}
			}
			$report_body =  $this->innerHTML($page_body);
			//now we are done with manipulating the report body
			//place the report body inside the report layout
			$layout_body = $doc->getElementById("report-body");
			$this->setInnerHTML($layout_body, $report_body);
			$docf = $doc->saveHTML();
			return html_entity_decode($docf); //get the html of the report
		}
		return null;
	}

	/**
	 * Set the page records in export array format ( for excel, csv, json)
	 * Remove unwanted fields
	 * @return array
	 */
	private function parse_report_records()
	{
		$records = array();
		if (isset($this->view_data->records)) {
			$records = $this->view_data->records; //if page is a list page
			if (!empty($this->report_hidden_fields)) {
				foreach ($this->report_hidden_fields as $fieldname) {
					foreach ($records as &$record) {
						unset($record[$fieldname]);
					}
				}
			}
		} else {
			$record = $this->view_data; //if page is a view page
			if (!empty($this->report_hidden_fields)) {
				foreach ($this->report_hidden_fields as $fieldname) {
					unset($record[$fieldname]);
				}
			}

			$records = array($record);
		}
		return $records;
	}

	/**
	 * Get the inner html of a page element
	 * @return string
	 */
	private function innerHTML(\DOMElement $element)
	{
		$doc = $element->ownerDocument;
		$html = '';
		foreach ($element->childNodes as $node) {
			$html .= $doc->saveHTML($node);
		}
		return $html;
	}

	/**
	 * DomDocument Manipulation
	 * Set the inner html of a page element
	 * @return string
	 */
	private function setInnerHTML($element, $html)
	{
		$html = htmlentities($html);
		$fragment = $element->ownerDocument->createDocumentFragment();
		$fragment->appendXML($html);
		$clone = $element->cloneNode(); // Get element copy without children
		$clone->appendChild($fragment);
		$element->parentNode->replaceChild($clone, $element);
	}
}
