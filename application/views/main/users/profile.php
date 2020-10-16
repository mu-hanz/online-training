                        <div class="border-bottom pb-4 data-loading">

                            <h5 class="mt-4 mb-0">Profile</h5>

                            <form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" data-parsley-validate class="ajaxForm">
                                <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <input type="hidden" name="id" value="<?=$user->id;?>">
                                <input type="hidden" name="redirect_sweetalert" id="redirect_sweetalert" value="<?=$redirect_sweetalert;?>">
                                <!-- <div class="row mt-1">
                                    <div class="col-md-12">
                                        <?php if($user->oauth_photoURL == NULL) {
                                            $photo = base_url('assets/app/images/users/avatar.jpg');
                                        } else {
                                            $photo = $user->oauth_photoURL;
                                        } ?>
                                        <div class="mt-3 text-md-left text-center d-sm-flex">
                                            <img src="<?php echo $photo;?>" class="avatar float-md-left avatar-medium rounded-circle shadow mr-md-4" alt="">
                                            <?php if ($user->oauth_provider == null) { ?>
                                            <div class="mt-md-4 mt-3 mt-sm-0">
                                                <input type="file" name="oauth_photoURL" class="btn btn-primary mt-2" value="Change Picture">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>First Name</label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="first_name" id="first_name" type="text" class="form-control pl-5" placeholder="First Name :" value="<?=$user->first_name;?>" <?php if ($user->oauth_provider != null) { ?> readonly="" style="background-color:#ededed;" <?php } ?>>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Last Name</label>
                                            <i data-feather="user-check" class="fea icon-sm icons"></i>
                                            <input name="last_name" id="last_name" type="text" class="form-control pl-5" placeholder="Last Name :" value="<?=$user->last_name;?>" <?php if ($user->oauth_provider != null) { ?> readonly="" style="background-color:#ededed;" <?php } ?>>
                                        </div>
                                    </div><!--end col-->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Email</label>
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input name="email" id="email" type="email" class="form-control pl-5" placeholder="Email :" value="<?=$user->email;?>" <?php if ($user->oauth_provider != null) { ?> readonly="" style="background-color:#ededed;" <?php } ?> required>
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Phone</label>
                                            <i data-feather="phone" class="fea icon-sm icons"></i>
                                            <input name="phone" id="phone" type="text" class="form-control pl-5" placeholder="Phone :" value="<?=$user->phone;?>">
                                        </div> 
                                    </div><!--end col-->
                                </div>
                                <?php if ($user->oauth_provider == null) { ?>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Password</label>
                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                            <input name="password" id="password" type="password" class="form-control pl-5" placeholder="Password :">
                                            <small>Leave blank if you don't want to change the password</small>
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Confirm Password</label>
                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                            <input name="confirm_password" id="confirm_password" type="password" class="form-control pl-5" placeholder="Confirm Password :">
                                            <small>Leave blank if you don't want to change the password</small>
                                        </div> 
                                    </div><!--end col-->
                                </div>
                                <?php } ?>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Job Title</label>
                                            <i data-feather="briefcase" class="fea icon-sm icons"></i>
                                            <input name="job_title" id="job_title" type="text" class="form-control pl-5" placeholder="Job Title :" value="<?=$user->job_title;?>">
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Company</label>
                                            <i data-feather="home" class="fea icon-sm icons"></i>
                                            <input name="company" id="company" type="text" class="form-control pl-5" placeholder="Company :" value="<?=$user->company;?>">
                                        </div> 
                                    </div><!--end col-->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Company NPWP</label>
                                            <i data-feather="credit-card" class="fea icon-sm icons"></i>
                                            <input name="company_npwp" id="company_npwp" type="text" class="form-control pl-5" placeholder="Company NPWP :" value="<?=$user->company_npwp;?>">
                                        </div> 
                                    </div><!--end col-->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="form-group position-relative">
                                            <label>Company Address</label>
                                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                            <?php if ($user->company_address != null) { ?>
                                            <textarea name="company_address" id="company_address" rows="4" class="form-control pl-5" placeholder="Company Address :" value="<?=$user->company_address;?>"> <?=$user->company_address; ?></textarea>
                                            <?php } else { ?>
                                            <textarea name="company_address" id="company_address" rows="4" class="form-control pl-5" placeholder="Company Address :" value="<?=$user->company_address;?>"></textarea>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <input type="submit" id="submit" name="Save" class="btn btn-primary" value="Save Changes">
                                    </div>
                                </div>
                            </form>

                        </div>

                        
               