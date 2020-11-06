
<!-- Hero Start -->
<section class="bg-half bg-cart d-table w-100 bg-primary" style="background: url('<?php echo base_url('assets/main/images/account/bg.png');?>') center center;">
<div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                        <?php $used = 0;
                                foreach($this->cart->contents() as $items){
                        
                                    if($items['sku'] == 'voucher'){
                                        $used = 1;
                                        break;
                                    }
                                }

                                if($used == 1){
                                    $count = $this->cart->total_items() - 1;
                                } else {
                                    $count = $this->cart->total_items();
                                }
                        ?>
                            <h4 class="title text-light"> Order Cart (<span id="label_count"><?=$count;?></span>)</h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
                </section><!--end section-->
<!-- Start -->
<!-- Start -->
<section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="rounded shadow-lg p-4">
                        <?php if(!$this->ion_auth->logged_in()){?>
                        <div class="row mt-md-2 pt-md-3 mt-2 pt-2 mt-sm-0 pt-sm-0 justify-content-center">
                        <div class="col-12 text-center">
                            <div class="section-title">
                                <h4 class="title mb-4">Kamu belum Login</h4>
                                <p class="text-muted para-desc mx-auto">Silakan melakukan login / registrasi terlebih dahulu ke akun Kamu untuk dapat melanjutkan pembayaran.</p>
                                <div class="p-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="nav nav-pills nav-justified flex-sm-row rounded  mx-md-5" id="pills-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link rounded active" id="pills-cloud-tab" data-toggle="pill" href="#pills-cloud" role="tab" aria-controls="pills-cloud" aria-selected="true">
                                                                <div class="text-center pt-1 pb-1">
                                                                    <h4 class="title font-weight-normal mb-0">Log In</h4>
                                                                </div>
                                                            </a><!--end nav link-->
                                                        </li><!--end nav item-->
                                                        
                                                        <li class="nav-item">
                                                            <a class="nav-link rounded" id="pills-smart-tab" data-toggle="pill" href="#pills-smart" role="tab" aria-controls="pills-smart" aria-selected="false">
                                                                <div class="text-center pt-1 pb-1">
                                                                    <h4 class="title font-weight-normal mb-0">Sign Up</h4>
                                                                </div>
                                                            </a><!--end nav link-->
                                                        </li><!--end nav item-->

                                                    </ul><!--end nav pills-->
                                                </div><!--end col-->
                                            </div><!--end row-->

                                            <div class="row pt-2">
                                                <div class="col-12">
                                                    <div class="tab-content  form-body" id="pills-tabContent">
                                                        <div class="tab-pane fade active show " id="pills-cloud" role="tabpanel" aria-labelledby="pills-cloud-tab">
                                                        <form class="ajaxFormAuth login-form mt-4" action="<?php echo base_url('account/auth/login'); ?>" method="post">
                                                            <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">    
                                                                <div class="row mx-md-5">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group position-relative text-left">
                                                                            <label>Your Email <span class="text-danger">*</span></label>
                                                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                                                            <input type="text" class="form-control pl-5" placeholder="Email"  name="identity" required="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12">
                                                                        <div class="form-group position-relative text-left">
                                                                            <label>Password <span class="text-danger">*</span></label>
                                                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                                                            <input type="password" class="form-control pl-5" placeholder="Password" name="password" required="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12">
                                                                        <div class="d-flex justify-content-between">
                                                                            <div class="form-group">
                                                                                <div class="custom-control custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                                                    <label class="custom-control-label" for="customCheck1">Remember me</label>
                                                                                </div>
                                                                            </div>
                                                                            <p class="forgot-pass mb-0"><a href="<?php echo base_url('account/lost-password');?>" class="text-danger font-weight-bold mlink">Forgot password ?</a></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 mb-0">
                                                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                                                    </div>
                                                                    <div class="col-lg-12 mt-4 text-center">
                                                                        <h6>Or Login With</h6>
                                                                        <a class="btn btn-outline-light google-sign-in" href="javascript:void(0)" role="button" style="text-transform:none">
                                                                        <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                                                                        Login with Google
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                        </div><!--end teb pane-->
                                                        
                                                        <div class="tab-pane fade" id="pills-smart" role="tabpanel" aria-labelledby="pills-smart-tab">
                                                        <form class="ajaxFormAuth login-form mt-4" action="<?php echo base_url('account/auth/register'); ?>" method="post">
                                                            <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">    
                                                                <div class="row mx-md-5">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group position-relative text-left">                                               
                                                                            <label>First name <span class="text-danger">*</span></label>
                                                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                                                            <input type="text" class="form-control pl-5" placeholder="First Name" name="first_name" required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group position-relative text-left">                                                
                                                                            <label>Last name <span class="text-danger">*</span></label>
                                                                            <i data-feather="user-check" class="fea icon-sm icons"></i>
                                                                            <input type="text" class="form-control pl-5" placeholder="Last Name" name="last_name" required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group position-relative text-left">
                                                                            <label>Your Email <span class="text-danger">*</span></label>
                                                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                                                            <input type="email" class="form-control pl-5" placeholder="Email" name="email" required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group position-relative text-left">
                                                                            <label>Password <span class="text-danger">*</span></label>
                                                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                                                            <input type="password" class="form-control pl-5" placeholder="Password" name="password" required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group text-left">
                                                                            
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
                                                                    
                                                                </div>
                                                            </form>
                                                        </div><!--end teb pane-->
                                                    </div><!--end tab content-->
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div>
                            </div>
                        </div><!--end col-->
                        </div>
                        <?php } ?>

                        <section class="section-checkbox">
                            <div>
                            <input type="radio" id="control_01" name="select" value="1" class="mz-checkbox" checked>
                            <label for="control_01"> 
                            <div class="p-4 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>  
                                <h2>Personal</h2>
                                <p>Mendaftar untuk Pribadi</p>
                                </div>
                                
                            </label>
                            </div>
                            <div>
                            <input type="radio" id="control_02" name="select" value="2"  class="mz-checkbox">
                            <label for="control_02"> 
                                <div class="p-4 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                <h2>Company</h2>
                                <p>Mendaftar untuk Perusahaan</p>
                                </div>
                                
                            </label>
                            </div>
                        </section>

      
                        
                    <?php $cart = $this->cart->contents();
                            if(!empty($cart)):
                                foreach ($cart as $items):
                                    if($items['sku'] != 'voucher'):?>

                                        <div class="row">
                                            <div class="col-lg-12 mt-4 pt-2">
                                                <div class="card shadow rounded border-0 overflow-hidden">
                                                    <div class="row no-gutters">
                                                        <div class=" col-3 p-3">
                                                            <img src="<?php echo base_url('assets/main/images/voucher.png');?>" class="img-fluid" width="100">
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $items['name'];?></h5>
                                                                <button class="btn btn-primary" type="bubmit" >Masukan data Peserta</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php  endif;
                           endforeach;
                        endif; ?>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-5 col-md-5 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="rounded shadow-lg p-4 sticky-bar">
                            <div class="d-flex mb-4 justify-content-between">
                                <h5><?php echo $this->cart->total_items();?> Items</h5>
                                <a href="<?php echo base_url('events-cart');?>" class="text-muted h6 mlink">Show Details</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-center table-padding mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="h6 border-0">Subtotal</td>
                                            <td class="text-center font-weight-bold border-0">$ 2409</td>
                                        </tr>
                                        <tr>
                                            <td class="h6">Shipping Charge</td>
                                            <td class="text-center font-weight-bold">$ 0.00</td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td class="h5 font-weight-bold">Total</td>
                                            <td class="text-center text-primary h4 font-weight-bold">$ 2409</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <ul class="list-unstyled mt-4 mb-0">
                                    <li>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <div class="form-group mb-0">
                                                <input type="radio" id="banktransfer" checked="checked" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="mt-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <div class="form-group mb-0">
                                                <input type="radio" id="chaquepayment" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="chaquepayment">Cheque Payment</label>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="mt-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <div class="form-group mb-0">
                                                <input type="radio" id="cashpayment" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="cashpayment">Cash on Delivery</label>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="mt-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <div class="form-group mb-0">
                                                <input type="radio" id="paypal" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="paypal">Paypal <a href="https://www.paypal.com/uk/webapps/mpp/paypal-popup" target="_blank" class="ml-2 text-primary">What is paypal?</a></label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="mt-4 pt-2">
                                 <?php if ($this->ion_auth->logged_in()) { ?>
                                
                                    <button class="btn btn-block btn-primary" type="bubmit">Place Order</button>
                                
                                 <?php } else { ?>
                                    <button class="btn btn-block btn-primary" type="bubmit" disabled >Place Order</button>
                                 <?php } ?>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->


        