                        <?php if($user->active == 0){?>
                        <div class="border-bottom pb-4">
                            <div class="alert alert-danger alert-pills mb-0 mt-3" role="alert">
                                <span class="badge badge-pill badge-light"> Action Required </span>
                                <span class="alert-content mr-5"> Email kamu belum di verfikasi silahkan konfirmasi sekarang </span>
                                <a href="<?php echo base_url('users/email_activation');?>"><span class="badge badge-pill badge-dark"> Konfirmasi Email Saya </span></a>
                            </div> 
                        </div>
                        <?php } ?>

                        <?php if($user->phone == null){?>
                        <div class="border-bottom pb-4">
                            <div class="alert alert-danger alert-pills mb-0 mt-3" role="alert">
                                <span class="badge badge-pill badge-light"> Complete Your Profile </span>
                                <span class="alert-content mr-5"> Silahkan lengkapi data profil kamu! </span>
                                <a href="<?php echo base_url('users/email_activation');?>"><span class="badge badge-pill badge-dark"> Edit Profil </span></a>
                            </div> 
                        </div>
                        <?php } ?>


                        <div class="border-bottom pb-4">

                        
                            <h5 class="mt-4 mb-0">Last Order</h5>

                            <div class="row">
                                <div class="col-lg-12 mt-4 pt-2">
                                    <div class="card shadow rounded border-0 overflow-hidden">
                                        <div class="row no-gutters">
                                            <div class="col-md-5 col-sm-5">
                                                <img src="<?php echo base_url('assets/main/images/blog/01.jpg');?>" class="img-fluid" alt="...">
                                            </div>
                                            <div class="col-md-7  col-sm-7">
                                                <div class="card-body">
                                                    <h5 class="card-title">Saas &amp; Software : Landrick</h5>
                                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div>

                        </div>

                        
               