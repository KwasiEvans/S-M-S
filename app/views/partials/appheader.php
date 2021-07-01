<div id="topbar" class="navbar navbar-expand-md fixed-top navbar-light bg-info">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php print_link(HOME_PAGE) ?>">
            <img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> <?php echo SITE_NAME ?>
            </a>
            <?php 
            if(user_login_status() == true ){ 
            ?>
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            </button>
            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <?php 
                            if(!empty(USER_PHOTO)){
                            ?>
                            <img class="img-fluid" style="height:30px;" src="<?php print_link(set_img_src(USER_PHOTO,30,30)); ?>" />
                                <?php
                                }
                                else{
                                ?>
                                <span class="avatar-icon"><i class="material-icons">account_box</i></span>
                                <?php
                                }
                                ?>
                                <span>Hi <?php echo ucwords(USER_NAME); ?> !</span>
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?php print_link('account') ?>"><i class="material-icons">account_box</i> My Account</a>
                                <a class="dropdown-item" href="<?php print_link('index/logout?csrf_token=' . Csrf::$token) ?>"><i class="material-icons">exit_to_app</i> Logout</a>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php 
                } 
                ?>
            </div>
        </div>
        <?php 
        if(user_login_status() == true ){ 
        ?>
        <nav id="sidebar" class="navbar-light bg-info">
            <ul class="nav navbar-nav w-100 flex-column align-self-start">
                <li class="menu-profile text-center nav-item">
                    <a class="avatar" href="<?php print_link('account') ?>">
                        <?php 
                        if(!empty(USER_PHOTO)){
                        ?>
                        <img class="img-fluid" src="<?php print_link(set_img_src(USER_PHOTO,260,200)); ?>" />
                            <?php
                            }
                            else{
                            ?>
                            <span class="avatar-icon"><i class="material-icons">account_box</i></span>
                            <?php
                            }
                            ?>
                        </a>
                        <h5 class="user-name">Hi 
                            <?php echo ucwords(USER_NAME); ?>
                            <small class="text-muted"><?php echo ACL::$user_role; ?> </small>
                        </h5>
                        <div class="dropdown menu-dropdown">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">account_box</i>
                            </button>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?php print_link('account') ?>"><i class="material-icons">account_box</i> My Account</a>
                                <a class="dropdown-item" href="<?php print_link('index/logout?csrf_token=' . Csrf::$token) ?>"><i class="material-icons">exit_to_app</i> Logout</a>
                            </ul>
                        </div>
                    </li>
                </ul>
                <?php Html :: render_menu(Menu :: $navbarsideleft  , "nav navbar-nav w-100 flex-column align-self-start"  , "accordion"); ?>
            </nav>
            <?php 
            } 
            ?>