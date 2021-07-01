<?php 
class PasswordmanagerController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->tablename = "users";
	}
	function index(){
		$this->render_view("passwordmanager/index.php", null, "info_layout.php");
	}
	function postresetlink(){
		if(!empty($this->post->email)){
			$email = $this->post->email;
			$tablename = $this->tablename;
			$db = $this->GetModel();
			$db->where ("email", $email); //get user by email
			$user = $db->getOne($tablename, array('id', 'username'));
			if(!empty($user)){
				//Generate new password reset
				$password_reset_key = password_hash(random_str(), PASSWORD_DEFAULT);
				$date_to_expire = format_date("+1day");
				$modeldata = array(
					"password_reset_key" => hash_value($password_reset_key),
					"password_expire_date" => $date_to_expire
				);
				$user_id = $user['id'];
				$db->where ("id", $user_id);
				$db->update($tablename, $modeldata);
				$reset_link = SITE_ADDR."Passwordmanager/updatepassword?key=$password_reset_key";
				$sitename = SITE_NAME;
				$user_name = $user['username'];
				$mailtitle = "$sitename password reset";
				//Password reset html template
				$mailbody = file_get_contents(PAGES_DIR . "passwordmanager/password_reset_email_template.html");
				$mailbody = str_ireplace("{{username}}", $user_name, $mailbody);
				$mailbody = str_ireplace("{{link}}" , $reset_link,$mailbody);
				$mailbody = str_ireplace("{{sitename}}" , $sitename,$mailbody);
				$mailer = new Mailer;
				if($mailer->send_mail($email, $mailtitle, $mailbody) == true){
					$this->render_view("passwordmanager/password_reset_link_sent.php", $mailbody, "info_layout.php");
				}
				else{
					$msg = "Error sending email. Please contact system administrator for more info";
					$this->render_view("errors/error_general.php", $msg, "info_layout.php");
				}
			}
			else{
				$this->set_page_error("The email address is not registered on the system");
				$this->render_view("passwordmanager/index.php", null, "info_layout.php");
			}
		}
		else{
			$this->redirect("passwordmanager");
		}
	}
	function updatepassword(){
		$password_key = get_value("key"); //get password resek key from $_GET
		if(!empty($password_key)){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$hashed_key = hash_value($password_key);
			$db->where ("password_reset_key", $hashed_key);
			$date_to_expire = $db->getValue($tablename, "password_expire_date");
			if(!empty($date_to_expire)){
				$password_has_not_expired =  new DateTime($date_to_expire) > new DateTime();
				if($password_has_not_expired){
					if(!empty($_POST['password'])){
						$password = $_POST["password"]; 
						$cpassword = $_POST["cpassword"];
						if($password == $cpassword){
							$new_password_hash = password_hash($password , PASSWORD_DEFAULT);
							$new_date_to_expire = format_date("3 months");
							$new_password_data = array(
								"password" => $new_password_hash,
								"password_reset_key" => null,
								"password_expire_date" => $new_date_to_expire
							);
							$db->where ("password_reset_key", $hashed_key);
							$db->update($tablename, $new_password_data);
							if($db->getRowCount()){
								$this->render_view("passwordmanager/password_reset_completed.php", null, "info_layout.php");
							}
							else{
								$this->render_view("passwordmanager/password_reset_error.php", null, "info_layout.php");
							}
						}
						else{
							$this->set_page_error("Your password confirmation is not consistent");
							$this->render_view("passwordmanager/password_reset_form.php", null, "info_layout.php");
						}
					}
					else{
						$this->render_view("passwordmanager/password_reset_form.php", null, "info_layout.php");
					}
				}
				else{
					$this->set_page_error("Password reset key has expired. Please start a new password request");
					$this->render_view("passwordmanager/index.php", null, "info_layout.php");
				}
			}
			else{
				$this->render_view("errors/error_general.php", "Invalid Password Reset Key", "info_layout.php");
			}	
		}
		else{
			$this->redirect("passwordmanager");
		}
	}
}