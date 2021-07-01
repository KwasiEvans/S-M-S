<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("admission/add");
$can_edit = ACL::is_allowed("admission/edit");
$can_view = ACL::is_allowed("admission/view");
$can_delete = ACL::is_allowed("admission/delete");
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
                    <h4 class="record-title">Admission</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("admission/add") ?>">
                        <i class="material-icons">add</i>                               
                        Add New Admission 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('admission'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('admission'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('admission'); ?>">
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
                            <div id="admission-list-records">
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
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['pupils_full_name']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="pupils_full_name" 
                                                        data-title="Enter Pupils Full Name" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Pupils Full Name:  
                                                        </span>
                                                        <?php echo $data['pupils_full_name']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['birth_certificate_no']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="birth_certificate_no" 
                                                        data-title="Enter Birth Certificate No" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Birth Certificate No:  
                                                        </span>
                                                        <?php echo $data['birth_certificate_no']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['age']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="age" 
                                                        data-title="Enter Age" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Age:  
                                                        </span>
                                                        <?php echo $data['age']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $class); ?>' 
                                                        data-value="<?php echo $data['class']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="class" 
                                                        data-title="Select a value ..." 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="select" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Class:  
                                                        </span>
                                                        <?php echo $data['class']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $gender); ?>' 
                                                        data-value="<?php echo $data['gender']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="gender" 
                                                        data-title="Enter Gender" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="radiolist" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Gender:  
                                                        </span>
                                                        <?php echo $data['gender']; ?> 
                                                    </span>
                                                </div>
                                                <tr  class="td-photo">
                                                    <th class="title">  </th>
                                                    <td class=""><img class="img img-thumbnail" alt="nngf" width="150" height="150" src="<?php echo $data['photo']; ?>"></img></td>
                                                </tr>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['upi']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="upi" 
                                                        data-title="Enter Upi" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Upi:  
                                                        </span>
                                                        <?php echo $data['upi']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $special_need); ?>' 
                                                        data-value="<?php echo $data['special_need']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="special_need" 
                                                        data-title="Enter Special Need" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="radiolist" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Special Need:  
                                                        </span>
                                                        <?php echo $data['special_need']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['father_name']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="father_name" 
                                                        data-title="Enter Father Name" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Father Name:  
                                                        </span>
                                                        <?php echo $data['father_name']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['mother_name']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="mother_name" 
                                                        data-title="Enter Mother Name" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Mother Name:  
                                                        </span>
                                                        <?php echo $data['mother_name']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['father_contact']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="father_contact" 
                                                        data-title="Enter Father Contact" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="number" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Father Contact:  
                                                        </span>
                                                        <?php echo $data['father_contact']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['mother_contact']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="mother_contact" 
                                                        data-title="Enter Mother Contact" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="number" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Mother Contact:  
                                                        </span>
                                                        <?php echo $data['mother_contact']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['school_fee']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="school_fee" 
                                                        data-title="Enter School Fee" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            School Fee:  
                                                        </span>
                                                        <?php echo $data['school_fee']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['graduation_fee']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="graduation_fee" 
                                                        data-title="Enter Graduation Fee" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Graduation Fee:  
                                                        </span>
                                                        <?php echo $data['graduation_fee']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['lunch']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="lunch" 
                                                        data-title="Enter Lunch" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Lunch:  
                                                        </span>
                                                        <?php echo $data['lunch']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-source='<?php echo json_encode_quote(Menu :: $bording); ?>' 
                                                        data-value="<?php echo $data['bording']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="bording" 
                                                        data-title="Select a value ..." 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="select" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Bording:  
                                                        </span>
                                                        <?php echo $data['bording']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['guardian_name']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="guardian_name" 
                                                        data-title="Enter Guardian Name" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Guardian Name:  
                                                        </span>
                                                        <?php echo $data['guardian_name']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['guardian_contact']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="guardian_contact" 
                                                        data-title="Enter Guardian Contact" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Guardian Contact:  
                                                        </span>
                                                        <?php echo $data['guardian_contact']; ?> 
                                                    </span>
                                                </div>
                                                <div class="mb-2">  
                                                    <span <?php if($can_edit){ ?> data-value="<?php echo $data['admission_fee']; ?>" 
                                                        data-pk="<?php echo $data['id'] ?>" 
                                                        data-url="<?php print_link("admission/editfield/" . urlencode($data['id'])); ?>" 
                                                        data-name="admission_fee" 
                                                        data-title="Enter Admission Fee" 
                                                        data-placement="left" 
                                                        data-toggle="click" 
                                                        data-type="text" 
                                                        data-mode="popover" 
                                                        data-showbuttons="left" 
                                                        class="is-editable" <?php } ?>>
                                                        <span class="font-weight-light text-muted ">
                                                            Admission Fee:  
                                                        </span>
                                                        <?php echo $data['admission_fee']; ?> 
                                                    </span>
                                                </div>
                                                <div class="td-btn">
                                                    <?php if($can_view){ ?>
                                                    <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("admission/view/$rec_id"); ?>">
                                                        <i class="material-icons">visibility</i> View
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_edit){ ?>
                                                    <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("admission/edit/$rec_id"); ?>">
                                                        <i class="material-icons">edit</i> Edit
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_delete){ ?>
                                                    <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("admission/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
