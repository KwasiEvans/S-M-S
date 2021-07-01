<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Apply For Admission<br>
                        <strong> <br>Lower Primary Subjects (Grade 1, 2, 3)</strong><br>
                            Subjects taught at lower primary include:<br>
                                Literacy Activities or Braille Literacy Activities<br>
                                    Kiswahili Language Activities or Kenya Sign Language (for deaf learners)<br>
                                        English Language Activities<br>
                                            Mathematical Activities<br>
                                                Environmental Activities<br>
                                                    Hygiene and Nutrition Activities<br>
                                                        Religious Education Activities<br>
                                                            Movement and Creative Activities<br></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <div  class="">
                                                <div class="container">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-7 comp-grid">
                                                            <?php $this :: display_page_errors(); ?>
                                                            <div  class="bg-light p-3 animated fadeIn page-content">
                                                                <form id="apply_for_admission-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("apply_for_admission/add?csrf_token=$csrf_token") ?>" method="post">
                                                                    <div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="surname">Surname <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-surname"  value="<?php  echo $this->set_field_value('surname',""); ?>" type="text" placeholder="Enter Surname"  required="" name="surname"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-last_name"  value="<?php  echo $this->set_field_value('last_name',""); ?>" type="text" placeholder="Enter Last Name"  required="" name="last_name"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-first_name"  value="<?php  echo $this->set_field_value('first_name',""); ?>" type="text" placeholder="Enter First Name"  required="" name="first_name"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="year_of_birth">Year Of Birth <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <input id="ctrl-year_of_birth" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('year_of_birth',datetime_now()); ?>" type="datetime" name="year_of_birth" placeholder="Enter Year Of Birth" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="Y-m-d" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                                                        <div class="input-group-append">
                                                                                                            <span class="input-group-text"><i class="material-icons">date_range</i></span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="photo">Photo <span class="text-danger">*</span></label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <div class="dropzone required" input="#ctrl-photo" fieldname="photo"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="3" maximum="1">
                                                                                                            <input name="photo" id="ctrl-photo" required="" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('photo',""); ?>" type="text"  />
                                                                                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                                                                <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="gender">Gender <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <?php
                                                                                                            $gender_options = Menu :: $gender;
                                                                                                            if(!empty($gender_options)){
                                                                                                            foreach($gender_options as $option){
                                                                                                            $value = $option['value'];
                                                                                                            $label = $option['label'];
                                                                                                            //check if current option is checked option
                                                                                                            $checked = $this->set_field_checked('gender', $value, "");
                                                                                                            ?>
                                                                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                                                                <input id="ctrl-gender" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value ?>" type="radio" required=""   name="gender" />
                                                                                                                    <span class="custom-control-label"><?php echo $label ?></span>
                                                                                                                </label>
                                                                                                                <?php
                                                                                                                }
                                                                                                                }
                                                                                                                ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="class">Class <span class="text-danger">*</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <?php
                                                                                                                $class_options = Menu :: $class2;
                                                                                                                if(!empty($class_options)){
                                                                                                                foreach($class_options as $option){
                                                                                                                $value = $option['value'];
                                                                                                                $label = $option['label'];
                                                                                                                //check if current option is checked option
                                                                                                                $checked = $this->set_field_checked('class', $value, "");
                                                                                                                ?>
                                                                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                                                                    <input id="ctrl-class" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value ?>" type="radio" required=""   name="class" />
                                                                                                                        <span class="custom-control-label"><?php echo $label ?></span>
                                                                                                                    </label>
                                                                                                                    <?php
                                                                                                                    }
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="with_birth_certificate">With Birth Certificate <span class="text-danger">*</span></label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="">
                                                                                                                    <select required=""  id="ctrl-with_birth_certificate" name="with_birth_certificate"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                                        <option value="">Select a value ...</option>
                                                                                                                        <?php
                                                                                                                        $with_birth_certificate_options = Menu :: $bording;
                                                                                                                        if(!empty($with_birth_certificate_options)){
                                                                                                                        foreach($with_birth_certificate_options as $option){
                                                                                                                        $value = $option['value'];
                                                                                                                        $label = $option['label'];
                                                                                                                        $selected = $this->set_field_selected('with_birth_certificate', $value, "");
                                                                                                                        ?>
                                                                                                                        <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                                                                            <?php echo $label ?>
                                                                                                                        </option>                                   
                                                                                                                        <?php
                                                                                                                        }
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="upi">Upi <span class="text-danger">*</span></label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="">
                                                                                                                    <input id="ctrl-upi"  value="<?php  echo $this->set_field_value('upi',""); ?>" type="text" placeholder="Enter Upi"  required="" name="upi"  class="form-control " />
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group ">
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-4">
                                                                                                                    <label class="control-label" for="resdence">Resdence <span class="text-danger">*</span></label>
                                                                                                                </div>
                                                                                                                <div class="col-sm-8">
                                                                                                                    <div class="">
                                                                                                                        <input id="ctrl-resdence"  value="<?php  echo $this->set_field_value('resdence',""); ?>" type="text" placeholder="Enter Resdence"  required="" name="resdence"  class="form-control " />
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group ">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <label class="control-label" for="special_conditions">Special Conditions <span class="text-danger">*</span></label>
                                                                                                                    </div>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <div class="">
                                                                                                                            <?php
                                                                                                                            $special_conditions_options = Menu :: $special_need;
                                                                                                                            if(!empty($special_conditions_options)){
                                                                                                                            foreach($special_conditions_options as $option){
                                                                                                                            $value = $option['value'];
                                                                                                                            $label = $option['label'];
                                                                                                                            //check if current option is checked option
                                                                                                                            $checked = $this->set_field_checked('special_conditions', $value, "");
                                                                                                                            ?>
                                                                                                                            <label class="custom-control custom-radio custom-control-inline">
                                                                                                                                <input id="ctrl-special_conditions" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value ?>" type="radio" required=""   name="special_conditions" />
                                                                                                                                    <span class="custom-control-label"><?php echo $label ?></span>
                                                                                                                                </label>
                                                                                                                                <?php
                                                                                                                                }
                                                                                                                                }
                                                                                                                                ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-group ">
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <label class="control-label" for="parent_contact_no">Parent Contact No <span class="text-danger">*</span></label>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-8">
                                                                                                                            <div class="">
                                                                                                                                <input id="ctrl-parent_contact_no"  value="<?php  echo $this->set_field_value('parent_contact_no',""); ?>" type="text" placeholder="Enter Parent Contact No"  required="" name="parent_contact_no"  class="form-control " />
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group ">
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-sm-4">
                                                                                                                                <label class="control-label" for="father_full_name">Father Full Name <span class="text-danger">*</span></label>
                                                                                                                            </div>
                                                                                                                            <div class="col-sm-8">
                                                                                                                                <div class="">
                                                                                                                                    <input id="ctrl-father_full_name"  value="<?php  echo $this->set_field_value('father_full_name',""); ?>" type="text" placeholder="Enter Father Full Name"  required="" name="father_full_name"  class="form-control " />
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="form-group ">
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-sm-4">
                                                                                                                                    <label class="control-label" for="mother_full_name">Mother Full Name <span class="text-danger">*</span></label>
                                                                                                                                </div>
                                                                                                                                <div class="col-sm-8">
                                                                                                                                    <div class="">
                                                                                                                                        <input id="ctrl-mother_full_name"  value="<?php  echo $this->set_field_value('mother_full_name',""); ?>" type="text" placeholder="Enter Mother Full Name"  required="" name="mother_full_name"  class="form-control " />
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="form-group ">
                                                                                                                                <div class="row">
                                                                                                                                    <div class="col-sm-4">
                                                                                                                                        <label class="control-label" for="home_county">Home County <span class="text-danger">*</span></label>
                                                                                                                                    </div>
                                                                                                                                    <div class="col-sm-8">
                                                                                                                                        <div class="">
                                                                                                                                            <input id="ctrl-home_county"  value="<?php  echo $this->set_field_value('home_county',""); ?>" type="text" placeholder="Enter Home County"  required="" name="home_county"  class="form-control " />
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                                                                <div class="form-ajax-status"></div>
                                                                                                                                <button class="btn btn-primary" type="submit">
                                                                                                                                    Submit
                                                                                                                                    <i class="material-icons">send</i>
                                                                                                                                </button>
                                                                                                                            </div>
                                                                                                                        </form>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </section>
