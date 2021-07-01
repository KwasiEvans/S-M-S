        <?php 
        $page_id = null;
        $comp_model = new SharedController;
        ?>
        <div  class=" py-5">
            <div class="container">
                <div class="row ">
                    <div class="col-md-8 comp-grid">
                        <div class="">
                            <div class="fadeIn animated mb-4">
                                <div class="text-capitalize">
                                    <h2 class="text-capitalize">Welcome To <?php echo SITE_NAME ?></h2>
                                </div>
                            </div>
                            Full Pre-School Admissions Guide 
                            Welcome from the Director of Admissions
                            We are so pleased that you are considering The Center for Early Education for your child and family.  
                            At The Center, our mission guides everything that we do. We work to ultimately graduate students who are joyful, resilient, life-long learners and we never forget about the importance of each day of this wonderful journey! Our philosophy combines a nurturing, inclusive learning environment with an increasingly challenging academic program that addresses the developmental needs of each child. We cannot wait to get to know your family and introduce you to our program and community.
                            Embarking on an admissions process is a big deal. We know that families experience this process in many different ways. As parents in the school search, while we research, think and write about our children, consider our family’s deepest values, create spreadsheets, explore websites, talk with friends and teachers, map out distances, examine viewbooks, and attend events, what we’re really doing is dreaming about our children’s future, next year and many years down the road. We’re finding a school and a community that we admire, trust, love, and are excited to partner with in raising our children. Our team is looking forward to being by your side in this process.
                            Clearly, 2020-21 is a different kind of a year which will impact the admissions process for application to 2021-22. Schools like The Center are working hard to care for their communities and educate their students through an ever-changing landscape. We’re proud of our faculty, support staff and administrators who pivoted quickly to provide remote learning experiences to our entire student body in Spring 2020 and we cannot wait for an eventual return to the in-person learning that we know and love. While no school can definitively say what the 2020-21 school year will look like from start to finish, due to constantly evolving guidelines and environment, I know that our approach will always put children, families, and teachers first and will be based on health guidelines and our core values of Responsibility, Caring, Inclusion, and Honesty.
                            Our comprehensive admissions viewbook will be emailed to all applicants. In the meantime, we invite you to explore our website to learn more about The Center’s program, philosophy, community, and admissions process and to call or email us at any time with questions. 
                            We’re looking forward to getting to know and partner with your family over the coming year!
                        </div>
                    </div>
                    <div class="col-md-4 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        
                        <div  class="bg-light p-3 animated fadeIn page-content">
                            <div>
                                <h4><i class="material-icons">lock_open</i> User Login</h4>
                                <hr />
                                <?php 
                                $this :: display_page_errors(); 
                                ?>
                                <form name="loginForm" action="<?php print_link('index/login/?csrf_token=' . Csrf::$token); ?>" class="needs-validation form page-form" method="post">
                                    <div class="input-group form-group">
                                        <input placeholder="Username" name="username"  required="required" class="form-control" type="text"  />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="form-control-feedback material-icons">account_circle</i></span>
                                        </div>
                                    </div>
                                    <div class="input-group form-group">
                                        <input  placeholder="Password" required="required" v-model="user.password" name="password" class="form-control " type="password" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="form-control-feedback material-icons">lock</i></span>
                                        </div>
                                    </div>
                                    <div class="row clearfix mt-3 mb-3">
                                        <div class="col-6">
                                            <label class="">
                                                <input value="true" type="checkbox" name="rememberme" />
                                                Remember Me
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <a href="<?php print_link('passwordmanager') ?>" class="text-danger"> Reset Password?</a>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary btn-block btn-md" type="submit"> 
                                            <i class="load-indicator">
                                                <clip-loader :loading="loading" color="#fff" size="20px"></clip-loader> 
                                            </i>
                                            Login <i class="material-icons">lock_open</i>
                                        </button>
                                    </div>
                                    <hr />
                                    <div class="text-center">
                                        Don't Have an Account? <a href="<?php print_link("index/register") ?>" class="btn btn-success">Register
                                        <i class="material-icons">account_box</i></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        