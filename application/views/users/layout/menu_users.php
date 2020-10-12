
                    <aside>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card mb-4">
                                    <div class="card-body px-3 py-2">
                                        <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                                            <img src="<?php echo base_url('assets/app/images/users/avatar.jpg');?>" class="img-lg rounded-circle" alt="profile image">
                                            <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                                                <h5 class="mb-0 small" ><?php echo $user->first_name.' '.$user->last_name;?></h5>
                                                <p class="text-muted mb-1 small"><?php echo $user->email;?></p>
                                                <?php if($user->active == 0){?>
                                                <p class="mb-0 text-danger font-weight-bold small"><i class="las la-times-circle"></i> Not Verified</p>
                                                <?php } else { ?>
                                                    <p class="mb-0 text-success font-weight-bold small"><i class="las la-check-circle"></i> Verified</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <ul class="nav flex-column dash-nav mz-menu">
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="<?php echo base_url('users/dashboard');?>">
                                        <div><i class="las la-arrow-right"></i>Dashboard</div>
                                        <div class="d-flex  align-items-center">
                                            <p class="mb-0 text-small text-success">
                                                Profile Verified
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="<?php echo base_url('users/dashboard/my_order');?>">
                                        <div><i class="las la-cloud-download-alt"></i>Order Saya</div>
                                        <div class="d-flex  align-items-center">
                                            <p class="mb-0 text-small">7 order</p>
                                        </div>
                                    </a>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="dash-my-items.html">
                                        <div><i class="las la-file"></i>My items</div>
                                        <div class="d-flex  align-items-center">
                                            <p class="mb-0 text-small text-danger">2 Pending</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="dash-add-item.html">
                                        <div><i class="las la-plus"></i>Add item</div>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="<?php echo base_url('users/dashboard/my_profile');?>">
                                        <div><i class="las la-user-friends"></i>Daftar Orang</div>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="<?php echo base_url('users/dashboard/my_profile');?>">
                                        <div><i class="las la-user-check"></i>Profil Saya</div>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center" aria-current="page" href="dash-invoice.html">
                                        <div><i class="las la-receipt"></i>Invoice</div>
                                        <div class="d-flex  align-items-center">
                                            <p class="mb-0 text-small text-success">

                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center text-danger" aria-current="page" href="#">
                                        <div><i class="las la-sign-out-alt"></i>Logout</div>

                                    </a>
                                </li>
                            </ul>

                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center mt-lg-6 mt-sm-3 mb-1 text-muted">
                                <span>Help center</span>
                                <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </a>
                            </h6>
                            <ul class="nav flex-column dash-nav">

                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center text-small" aria-current="page" href="#">

                                        Faq
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center text-small" aria-current="page" href="#">
                                        Panduan

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active d-flex justify-content-between align-items-center text-small" aria-current="page" href="#">
                                        Hubungi Kami

                                    </a>
                                </li>
                            </ul>

                        </div>
                    </aside>