<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="material-icons ">dashboard</i>'
		),
		
		array(
			'path' => 'users', 
			'label' => 'Users', 
			'icon' => '<i class="material-icons mi-xxs">verified_user</i>'
		),
		
		array(
			'path' => 'admission', 
			'label' => 'Admission', 
			'icon' => '<i class="material-icons mi-sm">airline_seat_recline_extra</i>'
		),
		
		array(
			'path' => 'announcement', 
			'label' => 'Announcement', 
			'icon' => '<i class="material-icons mi-xs">rowing</i>'
		),
		
		array(
			'path' => 'feestracture', 
			'label' => 'Feestracture', 
			'icon' => '<i class="material-icons mi-md">attach_file</i>'
		),
		
		array(
			'path' => 'apply_for_admission', 
			'label' => 'Apply For Admission', 
			'icon' => '<i class="material-icons mi-md">touch_app</i>'
		),
		
		array(
			'path' => 'assignment', 
			'label' => 'Assignment', 
			'icon' => '<i class="material-icons mi-md">arrow_drop_down_circle</i>'
		),
		
		array(
			'path' => 'event', 
			'label' => 'Event', 
			'icon' => '<i class="material-icons mi-md">beenhere</i>'
		),
		
		array(
			'path' => 'enrolment', 
			'label' => 'Enrolment', 
			'icon' => '<i class="material-icons mi-md">bubble_chart</i>'
		),
		
		array(
			'path' => 'perfomance', 
			'label' => 'Perfomance', 
			'icon' => '<i class="material-icons mi-md">call_merge</i>'
		),
		
		array(
			'path' => 'how_to_make_payment', 
			'label' => 'How To Make Payment', 
			'icon' => ''
		)
	);
		
	
	
			public static $role = array(
		array(
			"value" => "headteacher", 
			"label" => "headteacher", 
		),
		array(
			"value" => "pupils", 
			"label" => "pupils", 
		),);
		
			public static $account_status = array(
		array(
			"value" => "Active", 
			"label" => "Active", 
		),
		array(
			"value" => "Pending", 
			"label" => "Pending", 
		),
		array(
			"value" => "Blocked", 
			"label" => "Blocked", 
		),);
		
			public static $class = array(
		array(
			"value" => "babyclass", 
			"label" => "Babyclass", 
		),
		array(
			"value" => "pp1", 
			"label" => "Pp1", 
		),
		array(
			"value" => "pp2", 
			"label" => "Pp2", 
		),
		array(
			"value" => "grade1", 
			"label" => "Grade1", 
		),
		array(
			"value" => "grade2", 
			"label" => "Grade2", 
		),
		array(
			"value" => "grade3", 
			"label" => "Grade3", 
		),
		array(
			"value" => "grade4", 
			"label" => "Grade4", 
		),
		array(
			"value" => "class5", 
			"label" => "Grade5", 
		),
		array(
			"value" => "class6", 
			"label" => "Grade6", 
		),
		array(
			"value" => "class7", 
			"label" => "Grade7", 
		),
		array(
			"value" => "class8", 
			"label" => "Class8", 
		),);
		
			public static $gender = array(
		array(
			"value" => "Male", 
			"label" => "Male", 
		),
		array(
			"value" => "Female", 
			"label" => "Female", 
		),);
		
			public static $special_need = array(
		array(
			"value" => "no", 
			"label" => "No", 
		),
		array(
			"value" => "yes", 
			"label" => "Yes", 
		),);
		
			public static $bording = array(
		array(
			"value" => "yes", 
			"label" => "Yes", 
		),
		array(
			"value" => "no", 
			"label" => "No", 
		),);
		
			public static $author = array(
		array(
			"value" => "class teacher", 
			"label" => "Class Teacher", 
		),
		array(
			"value" => "headteacher", 
			"label" => "Headteacher", 
		),);
		
			public static $class2 = array(
		array(
			"value" => "babyclass", 
			"label" => "Babyclass", 
		),
		array(
			"value" => "pp1", 
			"label" => "Pp1", 
		),
		array(
			"value" => "pp2", 
			"label" => "Pp2", 
		),
		array(
			"value" => "grade 1", 
			"label" => "Grade1", 
		),
		array(
			"value" => "grade 2", 
			"label" => "Grade2", 
		),
		array(
			"value" => "grade 3", 
			"label" => "Grade 3", 
		),
		array(
			"value" => "grade 4", 
			"label" => "Grade 4", 
		),
		array(
			"value" => "class 5", 
			"label" => "Class 5", 
		),
		array(
			"value" => "class 6", 
			"label" => "Class 6", 
		),
		array(
			"value" => "class 7", 
			"label" => "Class 7", 
		),
		array(
			"value" => "class 8", 
			"label" => "Class 8", 
		),);
		
			public static $assignment_type = array(
		array(
			"value" => "midterm", 
			"label" => "Midterm", 
		),
		array(
			"value" => "cat", 
			"label" => "Cat", 
		),
		array(
			"value" => "edterm", 
			"label" => "Edterm", 
		),
		array(
			"value" => "holyday assigment", 
			"label" => "Holyday Assigment", 
		),
		array(
			"value" => "others", 
			"label" => "Others", 
		),);
		
			public static $author2 = array(
		array(
			"value" => "headteacher", 
			"label" => "Headteacher", 
		),
		array(
			"value" => "class teacher", 
			"label" => "Class Teacher", 
		),);
		
			public static $term = array(
		array(
			"value" => "term 1", 
			"label" => "Term 1", 
		),
		array(
			"value" => "term 2", 
			"label" => "Term 2", 
		),
		array(
			"value" => "term 3", 
			"label" => "Term 3", 
		),);
		
			public static $comment = array(
		array(
			"value" => "improved", 
			"label" => "Improved", 
		),
		array(
			"value" => "can do better", 
			"label" => "Can Do Better", 
		),
		array(
			"value" => "fair", 
			"label" => "Fair", 
		),
		array(
			"value" => "good", 
			"label" => "Good", 
		),);
		
			public static $payment_method = array(
		array(
			"value" => "m-pesa", 
			"label" => "M-Pesa", 
		),
		array(
			"value" => "bank", 
			"label" => "Bank", 
		),
		array(
			"value" => "cash", 
			"label" => "Cash", 
		),);
		
}