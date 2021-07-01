<?php 
/**
 * Apply_for_admission Page Controller
 * @category  Controller
 */
class Apply_for_admissionController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "apply_for_admission";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"surname", 
			"last_name", 
			"first_name", 
			"year_of_birth", 
			"photo", 
			"gender", 
			"class", 
			"with_birth_certificate", 
			"upi", 
			"resdence", 
			"special_conditions", 
			"parent_contact_no", 
			"mother_full_name", 
			"father_full_name", 
			"home_county");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				apply_for_admission.id LIKE ? OR 
				apply_for_admission.surname LIKE ? OR 
				apply_for_admission.last_name LIKE ? OR 
				apply_for_admission.first_name LIKE ? OR 
				apply_for_admission.year_of_birth LIKE ? OR 
				apply_for_admission.photo LIKE ? OR 
				apply_for_admission.gender LIKE ? OR 
				apply_for_admission.class LIKE ? OR 
				apply_for_admission.with_birth_certificate LIKE ? OR 
				apply_for_admission.upi LIKE ? OR 
				apply_for_admission.resdence LIKE ? OR 
				apply_for_admission.special_conditions LIKE ? OR 
				apply_for_admission.parent_contact_no LIKE ? OR 
				apply_for_admission.mother_full_name LIKE ? OR 
				apply_for_admission.father_full_name LIKE ? OR 
				apply_for_admission.home_county LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "apply_for_admission/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("apply_for_admission.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Apply For Admission";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("apply_for_admission/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"surname", 
			"last_name", 
			"first_name", 
			"year_of_birth", 
			"photo", 
			"gender", 
			"class", 
			"with_birth_certificate", 
			"upi", 
			"resdence", 
			"special_conditions", 
			"parent_contact_no", 
			"father_full_name", 
			"mother_full_name", 
			"home_county");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("apply_for_admission.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Apply For Admission";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("apply_for_admission/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("surname","last_name","first_name","year_of_birth","photo","gender","class","with_birth_certificate","upi","resdence","special_conditions","parent_contact_no","father_full_name","mother_full_name","home_county");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'surname' => 'required',
				'last_name' => 'required',
				'first_name' => 'required',
				'year_of_birth' => 'required',
				'photo' => 'required',
				'gender' => 'required',
				'class' => 'required',
				'with_birth_certificate' => 'required',
				'upi' => 'required',
				'resdence' => 'required',
				'special_conditions' => 'required',
				'parent_contact_no' => 'required',
				'father_full_name' => 'required',
				'mother_full_name' => 'required',
				'home_county' => 'required',
			);
			$this->sanitize_array = array(
				'surname' => 'sanitize_string',
				'last_name' => 'sanitize_string',
				'first_name' => 'sanitize_string',
				'year_of_birth' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'gender' => 'sanitize_string',
				'class' => 'sanitize_string',
				'with_birth_certificate' => 'sanitize_string',
				'upi' => 'sanitize_string',
				'resdence' => 'sanitize_string',
				'special_conditions' => 'sanitize_string',
				'parent_contact_no' => 'sanitize_string',
				'father_full_name' => 'sanitize_string',
				'mother_full_name' => 'sanitize_string',
				'home_county' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("apply_for_admission");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Apply For Admission";
		$this->render_view("apply_for_admission/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","surname","last_name","first_name","year_of_birth","photo","gender","class","with_birth_certificate","upi","resdence","special_conditions","parent_contact_no","father_full_name","mother_full_name","home_county");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'surname' => 'required',
				'last_name' => 'required',
				'first_name' => 'required',
				'year_of_birth' => 'required',
				'photo' => 'required',
				'gender' => 'required',
				'class' => 'required',
				'with_birth_certificate' => 'required',
				'upi' => 'required',
				'resdence' => 'required',
				'special_conditions' => 'required',
				'parent_contact_no' => 'required',
				'father_full_name' => 'required',
				'mother_full_name' => 'required',
				'home_county' => 'required',
			);
			$this->sanitize_array = array(
				'surname' => 'sanitize_string',
				'last_name' => 'sanitize_string',
				'first_name' => 'sanitize_string',
				'year_of_birth' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'gender' => 'sanitize_string',
				'class' => 'sanitize_string',
				'with_birth_certificate' => 'sanitize_string',
				'upi' => 'sanitize_string',
				'resdence' => 'sanitize_string',
				'special_conditions' => 'sanitize_string',
				'parent_contact_no' => 'sanitize_string',
				'father_full_name' => 'sanitize_string',
				'mother_full_name' => 'sanitize_string',
				'home_county' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("apply_for_admission.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("apply_for_admission");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("apply_for_admission");
					}
				}
			}
		}
		$db->where("apply_for_admission.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Apply For Admission";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("apply_for_admission/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","surname","last_name","first_name","year_of_birth","photo","gender","class","with_birth_certificate","upi","resdence","special_conditions","parent_contact_no","father_full_name","mother_full_name","home_county");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'surname' => 'required',
				'last_name' => 'required',
				'first_name' => 'required',
				'year_of_birth' => 'required',
				'photo' => 'required',
				'gender' => 'required',
				'class' => 'required',
				'with_birth_certificate' => 'required',
				'upi' => 'required',
				'resdence' => 'required',
				'special_conditions' => 'required',
				'parent_contact_no' => 'required',
				'father_full_name' => 'required',
				'mother_full_name' => 'required',
				'home_county' => 'required',
			);
			$this->sanitize_array = array(
				'surname' => 'sanitize_string',
				'last_name' => 'sanitize_string',
				'first_name' => 'sanitize_string',
				'year_of_birth' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'gender' => 'sanitize_string',
				'class' => 'sanitize_string',
				'with_birth_certificate' => 'sanitize_string',
				'upi' => 'sanitize_string',
				'resdence' => 'sanitize_string',
				'special_conditions' => 'sanitize_string',
				'parent_contact_no' => 'sanitize_string',
				'father_full_name' => 'sanitize_string',
				'mother_full_name' => 'sanitize_string',
				'home_county' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("apply_for_admission.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("apply_for_admission.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("apply_for_admission");
	}
}
