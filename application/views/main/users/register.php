<!-- Hero Start -->
<section class="bg-home d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="mr-lg-5">   
                            <img src="<?php echo base_url('assets/main/images/user/signup.svg');?>" class="img-fluid d-block mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="card login_page shadow rounded border-0">
                            <div class="card-body">
                                <h4 class="card-title text-center">Signup</h4>  
                                <form class="ajaxFormAuth login-form mt-4" action="<?php echo base_url('account/auth/register'); ?>" method="post">
                                <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">                                               
                                                <label>First name <span class="text-danger">*</span></label>
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input type="text" class="form-control pl-5" placeholder="First Name" name="first_name" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group position-relative">                                                
                                                <label>Last name <span class="text-danger">*</span></label>
                                                <i data-feather="user-check" class="fea icon-sm icons"></i>
                                                <input type="text" class="form-control pl-5" placeholder="Last Name" name="last_name" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Your Email <span class="text-danger">*</span></label>
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input type="email" class="form-control pl-5" placeholder="Email" name="email" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">
                                                <label>Password <span class="text-danger">*</span></label>
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" pattern=".{8,}"   required title="8 characters minimum" class="form-control pl-5" placeholder="Password" name="password" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                
                                                    <label>By clicking Register, you confirm that you have read the <a href="<?=base_url('pages/kebijakan-privasi-dan-syarat-ketentuan');?>" class="text-primary">Terms and Conditions</a></a></label>
                                            
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-block">Register</button>
                                        </div>
                                        <div class="col-lg-12 mt-4 text-center">
                                            <h6>Or Sign Up With</h6>
                                            <a class="btn btn-outline-light google-sign-in" href="javascript:void(0)" role="button" style="text-transform:none">
                                            <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                                            Sign Up with Google
                                            </a>
                                        </div>
                                        <div class="mx-auto">
                                            <p class="mb-0 mt-3"><small class="text-dark mr-2">Already have an account ?</small> <a href="<?php echo base_url('account/login');?>" class="text-primary font-weight-bold mlink">Sign in</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- Hero End -->