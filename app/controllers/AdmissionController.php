<?php 
/**
 * Admission Page Controller
 * @category  Controller
 */
class AdmissionController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "admission";
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
			"pupils_full_name", 
			"birth_certificate_no", 
			"age", 
			"class", 
			"gender", 
			"photo", 
			"upi", 
			"special_need", 
			"father_name", 
			"mother_name", 
			"father_contact", 
			"mother_contact", 
			"school_fee", 
			"graduation_fee", 
			"lunch", 
			"bording", 
			"guardian_name", 
			"guardian_contact", 
			"admission_fee");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				admission.id LIKE ? OR 
				admission.pupils_full_name LIKE ? OR 
				admission.birth_certificate_no LIKE ? OR 
				admission.age LIKE ? OR 
				admission.class LIKE ? OR 
				admission.gender LIKE ? OR 
				admission.photo LIKE ? OR 
				admission.upi LIKE ? OR 
				admission.special_need LIKE ? OR 
				admission.father_name LIKE ? OR 
				admission.mother_name LIKE ? OR 
				admission.father_contact LIKE ? OR 
				admission.mother_contact LIKE ? OR 
				admission.school_fee LIKE ? OR 
				admission.graduation_fee LIKE ? OR 
				admission.lunch LIKE ? OR 
				admission.bording LIKE ? OR 
				admission.guardian_name LIKE ? OR 
				admission.guardian_contact LIKE ? OR 
				admission.admission_fee LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "admission/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("admission.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Admission";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("admission/list.php", $data); //render the full page
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
			"pupils_full_name", 
			"birth_certificate_no", 
			"age", 
			"class", 
			"photo", 
			"gender", 
			"upi", 
			"school_fee", 
			"admission_fee", 
			"graduation_fee", 
			"bording", 
			"lunch", 
			"father_name", 
			"mother_name", 
			"father_contact", 
			"mother_contact", 
			"special_need", 
			"guardian_name", 
			"guardian_contact");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("admission.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Admission";
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
		return $this->render_view("admission/view.php", $record);
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
			$fields = $this->fields = array("pupils_full_name","birth_certificate_no","age","photo","gender","class","upi","school_fee","graduation_fee","admission_fee","lunch","bording","father_name","mother_name","father_contact","mother_contact","special_need","guardian_name","guardian_contact");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'pupils_full_name' => 'required',
				'birth_certificate_no' => 'required',
				'age' => 'required',
				'photo' => 'required',
				'gender' => 'required',
				'class' => 'required',
				'upi' => 'required',
				'school_fee' => 'required',
				'graduation_fee' => 'required',
				'admission_fee' => 'required',
				'lunch' => 'required',
				'bording' => 'required',
				'father_name' => 'required',
				'mother_name' => 'required',
				'father_contact' => 'required|numeric',
				'mother_contact' => 'required|numeric',
				'special_need' => 'required',
				'guardian_name' => 'required',
				'guardian_contact' => 'required',
			);
			$this->sanitize_array = array(
				'pupils_full_name' => 'sanitize_string',
				'birth_certificate_no' => 'sanitize_string',
				'age' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'gender' => 'sanitize_string',
				'class' => 'sanitize_string',
				'upi' => 'sanitize_string',
				'school_fee' => 'sanitize_string',
				'graduation_fee' => 'sanitize_string',
				'admission_fee' => 'sanitize_string',
				'lunch' => 'sanitize_string',
				'bording' => 'sanitize_string',
				'father_name' => 'sanitize_string',
				'mother_name' => 'sanitize_string',
				'father_contact' => 'sanitize_string',
				'mother_contact' => 'sanitize_string',
				'special_need' => 'sanitize_string',
				'guardian_name' => 'sanitize_string',
				'guardian_contact' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("admission");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Admission";
		$this->render_view("admission/add.php");
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
		$fields = $this->fields = array("id","pupils_full_name","birth_certificate_no","age","photo","gender","class","upi","school_fee","graduation_fee","admission_fee","lunch","bording","father_name","mother_name","father_contact","mother_contact","special_need","guardian_name","guardian_contact");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'pupils_full_name' => 'required',
				'birth_certificate_no' => 'required',
				'age' => 'required',
				'photo' => 'required',
				'gender' => 'required',
				'class' => 'required',
				'upi' => 'required',
				'school_fee' => 'required',
				'graduation_fee' => 'required',
				'admission_fee' => 'required',
				'lunch' => 'required',
				'bording' => 'required',
				'father_name' => 'required',
				'mother_name' => 'required',
				'father_contact' => 'required|numeric',
				'mother_contact' => 'required|numeric',
				'special_need' => 'required',
				'guardian_name' => 'required',
				'guardian_contact' => 'required',
			);
			$this->sanitize_array = array(
				'pupils_full_name' => 'sanitize_string',
				'birth_certificate_no' => 'sanitize_string',
				'age' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'gender' => 'sanitize_string',
				'class' => 'sanitize_string',
				'upi' => 'sanitize_string',
				'school_fee' => 'sanitize_string',
				'graduation_fee' => 'sanitize_string',
				'admission_fee' => 'sanitize_string',
				'lunch' => 'sanitize_string',
				'bording' => 'sanitize_string',
				'father_name' => 'sanitize_string',
				'mother_name' => 'sanitize_string',
				'father_contact' => 'sanitize_string',
				'mother_contact' => 'sanitize_string',
				'special_need' => 'sanitize_string',
				'guardian_name' => 'sanitize_string',
				'guardian_contact' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("admission.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("admission");
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
						return	$this->redirect("admission");
					}
				}
			}
		}
		$db->where("admission.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Admission";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("admission/edit.php", $data);
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
		$fields = $this->fields = array("id","pupils_full_name","birth_certificate_no","age","photo","gender","class","upi","school_fee","graduation_fee","admission_fee","lunch","bording","father_name","mother_name","father_contact","mother_contact","special_need","guardian_name","guardian_contact");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'pupils_full_name' => 'required',
				'birth_certificate_no' => 'required',
				'age' => 'required',
				'photo' => 'required',
				'gender' => 'required',
				'class' => 'required',
				'upi' => 'required',
				'school_fee' => 'required',
				'graduation_fee' => 'required',
				'admission_fee' => 'required',
				'lunch' => 'required',
				'bording' => 'required',
				'father_name' => 'required',
				'mother_name' => 'required',
				'father_contact' => 'required|numeric',
				'mother_contact' => 'required|numeric',
				'special_need' => 'required',
				'guardian_name' => 'required',
				'guardian_contact' => 'required',
			);
			$this->sanitize_array = array(
				'pupils_full_name' => 'sanitize_string',
				'birth_certificate_no' => 'sanitize_string',
				'age' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'gender' => 'sanitize_string',
				'class' => 'sanitize_string',
				'upi' => 'sanitize_string',
				'school_fee' => 'sanitize_string',
				'graduation_fee' => 'sanitize_string',
				'admission_fee' => 'sanitize_string',
				'lunch' => 'sanitize_string',
				'bording' => 'sanitize_string',
				'father_name' => 'sanitize_string',
				'mother_name' => 'sanitize_string',
				'father_contact' => 'sanitize_string',
				'mother_contact' => 'sanitize_string',
				'special_need' => 'sanitize_string',
				'guardian_name' => 'sanitize_string',
				'guardian_contact' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("admission.id", $rec_id);;
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
		$db->where("admission.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("admission");
	}
}
