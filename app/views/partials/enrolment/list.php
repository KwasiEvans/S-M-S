<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("enrolment/add");
$can_edit = ACL::is_allowed("enrolment/edit");
$can_view = ACL::is_allowed("enrolment/view");
$can_delete = ACL::is_allowed("enrolment/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="grid" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Enrolment</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("enrolment/add") ?>">
                        <i class="material-icons">add</i>                               
                        Add New Enrolment 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('enrolment'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="material-icons">search</i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <div class="">
                            <!-- Page bread crumbs components-->
                            <?php
                            if(!empty($field_name) || !empty($_GET['search'])){
                            ?>
                            <hr class="sm d-block d-sm-none" />
                            <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                <ul class="breadcrumb m-0 p-1">
                                    <?php
                                    if(!empty($field_name)){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('enrolment'); ?>">
                                            <i class="material-icons">arrow_back</i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                                        <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                                    </li>
                                    <?php 
                                    }   
                                    ?>
                                    <?php
                                    if(get_value("search")){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('enrolment'); ?>">
                                            <i class="material-icons">arrow_back</i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-capitalize">
                                        Search
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                            <!--End of Page bread crumbs components-->
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div  class="">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="enrolment-list-records">
                                <?php
                                if(!empty($records)){
                                ?>
                                <div id="page-report-body">
                                    <div class="row sm-gutters page-data" id="page-data-<?php echo $page_element_id; ?>">
                                        <!--record-->
                                        <?php
                                        $counter = 0;
                                        foreach($records as $data){
                                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                        $counter++;
                                        ?>
                                        <div class="col-sm-4">
                                            <div class="card-small p-2 mb-3 animated bounceIn">
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['enrol_year']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="enrol_year" 
                                                        data-title="Enter Enrol Year" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Enrol Year:  
                                                        </span>
                                                        <?php echo $data['enrol_year']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['number_of_boy']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="number_of_boy" 
                                                        data-title="Enter Number Of Boy" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Number Of Boy:  
                                                        </span>
                                                        <?php echo $data['number_of_boy']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['number_of_girls']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="number_of_girls" 
                                                        data-title="Enter Number Of Girls" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Number Of Girls:  
                                                        </span>
                                                        <?php echo $data['number_of_girls']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['age_below_6']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="age_below_6" 
                                                        data-title="Enter Age Below 6" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Age Below 6:  
                                                        </span>
                                                        <?php echo $data['age_below_6']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['age_above_10']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="age_above_10" 
                                                        data-title="Enter Age Above 10" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Age Above 10:  
                                                        </span>
                                                        <?php echo $data['age_above_10']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['number_of_dropout']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="number_of_dropout" 
                                                        data-title="Enter Number Of Dropout" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Number Of Dropout:  
                                                        </span>
                                                        <?php echo $data['number_of_dropout']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['transfer']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="transfer" 
                                                        data-title="Enter Transfer" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Transfer:  
                                                        </span>
                                                        <?php echo $data['transfer']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['total_pupils_in_school']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="total_pupils_in_school" 
                                                        data-title="Enter Total Pupils In School" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Total Pupils In School:  
                                                        </span>
                                                        <?php echo $data['total_pupils_in_school']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['pupils_with_upi']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="pupils_with_upi" 
                                                        data-title="Enter Pupils With Upi" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Pupils With Upi:  
                                                        </span>
                                                        <?php echo $data['pupils_with_upi']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['pupils_birth_certificate']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="pupils_birth_certificate" 
                                                        data-title="Enter Pupils Birth Certificate" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Pupils Birth Certificate:  
                                                        </span>
                                                        <?php echo $data['pupils_birth_certificate']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['pupils_without_certificate']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("enrolment/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="pupils_without_certificate" 
                                                        data-title="Enter Pupils Without Certificate" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Pupils Without Certificate:  
                                                        </span>
                                                        <?php echo $data['pupils_without_certificate']; ?> 
                                                    </span>
                                                </div>
                                                <div class="td-btn">
                                                    <?php if($can_view){ ?>
                                                    <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("enrolment/view/$rec_id"); ?>">
                                                        <i class="material-icons">visibility</i> View
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_edit){ ?>
                                                    <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("enrolment/edit/$rec_id"); ?>">
                                                        <i class="material-icons">edit</i> Edit
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_delete){ ?>
                                                    <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("enrolment/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                        <i class="material-icons">clear</i>
                                                        Delete
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                        <!--endrecord-->
                                    </div>
                                    <div class="row sm-gutters search-data" id="search-data-<?php echo $page_element_id; ?>"></div>
                                    <div>
                                    </div>
                                </div>
                                <?php
                                if($show_footer == true){
                                ?>
                                <div class=" border-top mt-2">
                                    <div class="row justify-content-center">    
                                        <div class="col-md-auto">   
                                        </div>
                                        <div class="col">   
                                            <?php
                                            if($show_pagination == true){
                                            $pager = new Pagination($total_records, $record_count);
                                            $pager->route = $this->route;
                                            $pager->show_page_count = true;
                                            $pager->show_record_count = true;
                                            $pager->show_page_limit =true;
                                            $pager->limit_count = $this->limit_count;
                                            $pager->show_page_number_list = true;
                                            $pager->pager_link_range=5;
                                            $pager->render();
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                }
                                else{
                                ?>
                                <div class="text-muted  animated bounce p-3">
                                    <h4><i class="material-icons">block</i> No record found</h4>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
