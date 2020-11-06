
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
                            <h4 class="title text-light"> Checkout (<span id="label_count"><?=$count;?></span>)</h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
                </section><!--end section-->
<!-- Start -->
<!-- Start -->
        <section class="section">
        <form id="ajaxFormCheckout" action="<?php echo base_url('events-checkout/place-order'); ?>" method="post">
         <input type="hidden" id="mz-csrf-checkout" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
         <input type="hidden" name="result_type" id="result-type" value="">
         <input type="hidden" name="result_data" id="result-data" value="">
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
                        <?php if($this->ion_auth->logged_in()){?>
                        <h5>Detail Order :</h5>
                        <?php } ?>
                         <?php $cart = $this->cart->contents();
                            if(!empty($cart)): 
                                $use_vouher = 0; $subtotal = 0; $subtotal_flexi = 0; $discount_voucher = 0;
                                foreach ($cart as $items):
                                    if($items['sku'] != 'voucher'): 


                                        if($items['used_flexi'] == 1){
                                            $subtotal_flexi += $items['subtotal']; 
                                            $subtotal += $items['old_subtotal'];
                                        } else {
                                            $subtotal_flexi += $items['subtotal'];
                                            $subtotal += $items['subtotal'];
                                        }
                                        ?> 

                                        <?php if($this->ion_auth->logged_in()){?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card shadow rounded border-0 overflow-hidden mt-3">
                                                    <div class="row no-gutters">
                                                        <div class=" col-3 p-3">
                                                            <img src="<?php echo base_url($items['images']);?>" class="img-fluid">
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="card-body">
                                                            
                                                                <h5 class="card-title"><?php echo $items['name'];?></h5>
                                                                <p>Jumlah Peserta : <?php echo $items['qty'];?></p>
                                                                <a href="javascript:void(0)" class="btn btn-primary add-participan-btn" data-id="<?php echo $items['id'];?>" data-qty="<?php echo $items['qty'];?>"> Pilih / Tambah data Peserta</a>
                                                                
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="col-12 mx-4">
                                                        <h5 class="pt-2 border-top">Peserta : <span class="badge badge-pill badge-danger" id="not-choose-<?php echo $items['id'];?>"> Belum dipilih </span></h5>
                                                        <div id="box-peserta-<?php echo $items['id'];?>">
                                                            
                                                        </div>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    <?php  else:
                                    $use_vouher = 1;
                                    $discount_voucher += $items['subtotal'];
                                    endif; 
                                    
                           endforeach;
                        endif; ?>


                        
                        </div>
                        <?php if($this->ion_auth->logged_in()){?>
                        <div class="rounded shadow-lg p-4 mt-5">
                            <h5 class="mb-0">Billing Details :</h5>

                                <?php $dataUser = $this->ion_auth->user()->row();?>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group position-relative">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input name="first_name" id="firstname" type="text" class="form-control" placeholder="First Name :" value="<?php echo $dataUser->first_name;?>" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="form-group position-relative">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input name="last_name" id="lastname" type="text" class="form-control" placeholder="Last Name :" value="<?php echo $dataUser->last_name;?>" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="form-group position-relative">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="No Handphone/WA (Aktif):" value="<?php echo $dataUser->phone;?>" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="form-group position-relative">
                                            <label>Company Name <span class="text-muted">(Optional)</span></label>
                                            <input name="company" id="companyname" type="text" class="form-control" placeholder="Company Name :" value="<?php echo $dataUser->company;?>">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="form-group position-relative">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <textarea name="company_address" class="form-control"  placeholder="Alamat Lengkap" required><?php echo $dataUser->company_address;?></textarea>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="form-group position-relative">
                                         <label>NPWP <span class="text-muted">(Optional)</span></label>
                                            <input name="company_npwp" type="text" class="form-control" placeholder="15 digit nomor npwp:" value="<?php echo $dataUser->company_npwp;?>">
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            
                        </div>

                    <?php } ?> <!--jika login-->
                    </div><!--end col-->

                    

                    <div class="col-lg-5 col-md-5 mt-4 mt-sm-0 pt-2 pt-sm-0" >
                        <div class="rounded shadow-lg p-4 sticky-bar">
                            <div class="d-flex mb-4 justify-content-between">
                                <h5><?php echo count($this->cart->contents())  -  $use_vouher;?> Items <?php echo $this->cart->total_items() -  $use_vouher;?> Participant's</h5>
                                <a href="<?php echo base_url('events-cart');?>" class="text-muted h6 mlink">Show Details</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-center table-padding mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="h6 border-0">Subtotal</td>
                                            <td class="text-center font-weight-bold border-0"><?= rupiah_num($subtotal);?> </td>
                                        </tr>
                                        <?php if($subtotal != $subtotal_flexi){?>
                                        <tr>
                                            <td class="h6">Discount Flexi</td>
                                            <td class="text-center  text-danger font-weight-bold">-<?php echo rupiah_num($subtotal- $subtotal_flexi);?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($discount_voucher != 0){?>
                                        <tr>
                                            <td class="h6">Discount Voucher</td>
                                            <td class="text-center  text-danger font-weight-bold"><?php echo rupiah_num($discount_voucher);?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr class="bg-light">
                                            <td class="h5 font-weight-bold">Total</td>
                                            <td class="text-center text-primary h4 font-weight-bold"><?= rupiah($this->cart->total());?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-4 pt-2">
                                 <?php if ($this->ion_auth->logged_in()) { ?>
                                
                                    <button class="btn btn-block btn-primary" id="place_order" type="bubmit">Place Order</button>
                                
                                 <?php } else { ?>
                                    <a href="javascript:void(0);" class="btn btn-block btn-warning" type="bubmit" disabled >Please Login to Continue</a>
                                 <?php } ?>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end container-->
            </form>                        
            <div class="modal fade" id="add-participan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content rounded shadow border-0">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Pilih atau tambah peserta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="bg-white p-3 rounded box-shadow">
                            <div class="row">
                            <div class="col-md-6">
                            <button type="button" class="btn btn-primary mb-4" id="add-new-participans"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg> 
                            Tambah</button>
                            
                            <button type="button" class="btn btn-secondary mb-4" id="back-participans" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> 
                            Kembali</button>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="s_participant" placeholder="search name...">
                            </div>
                            </div>
                            
                            <input type="hidden" id="event-id-modal">
                            <input type="hidden" id="event-qty-modal">
                            <div class="table-responsive bg-white shadow rounded"  id="table-peserta">
                                <table class="table mb-0 table-center">
                                    <thead>
                                        <tr>
                                        <th scope="col" width="80%">Nama Lengkap</th>
                                        <th scope="col"></th>
                                    
                                        </tr>
                                    </thead>
                                    <tbody id="display-participant">
                                        
                                    </tbody>
                                </table>
                            </div>
                                <div id="form-add-participan" style="display:none">
                                <form id="ajaxFormCheckoutUser" action="<?php echo base_url('events-checkout/add-participant'); ?>" method="post">
                                    <input type="hidden" id="mz-csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
                                    <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <input type="text" class="form-control" placeholder="Nama Lengkap"  name="name" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            
                                            <input type="text" class="form-control" placeholder="Jabatan"  name="job_title" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            
                                            <input type="email" class="form-control" placeholder="Email"  name="email" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            
                                            <input type="number" class="form-control" placeholder="No HP"  name="phone" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
        </section><!--end section-->
        <!-- End -->


        