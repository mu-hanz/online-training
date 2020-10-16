                        <div class="sidebar sticky-bar p-4 rounded shadow">
                            
                            <div class="widget">
                                <div class="row">
                                    <div class="col-6 mt-4 pt-2">
                                        <a href="account-profile.html" class="accounts <?php if ($this->uri->segment('2') == 'dashboard') { ?> active <?php } ?> rounded d-block shadow text-center py-3">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-dashboard"></i></span>
                                            <h6 class="title text-dark h6 my-0">Dashboard</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-6 mt-4 pt-2">
                                        <a href="<?=base_url();?>members" class="accounts <?php if ($this->uri->segment('1') == 'members' OR $this->uri->segment('1') == 'members-edit') { ?> active <?php } ?> rounded d-block shadow text-center py-3">
                                        <span class="pro-icons h3 text-muted"><i class="uil uil-users-alt"></i></span>
                                        <h6 class="title text-dark h6 my-0">Members</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-6 mt-4 pt-2">
                                        <a href="account-works.html" class="accounts rounded d-block shadow text-center py-3">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-file"></i></span>
                                            <h6 class="title text-dark h6 my-0">Works</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-6 mt-4 pt-2">
                                        <a href="account-messages.html" class="accounts rounded d-block shadow text-center py-3">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-envelope-star"></i></span>
                                            <h6 class="title text-dark h6 my-0">Messages</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-6 mt-4 pt-2">
                                        <a href="account-payments.html" class="accounts rounded d-block shadow text-center py-3">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-transaction"></i></span>
                                            <h6 class="title text-dark h6 my-0">Payments</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-6 mt-4 pt-2">
                                        <a href="auth-login-three.html" class="accounts rounded d-block shadow text-center py-3">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-sign-out-alt"></i></span>
                                            <h6 class="title text-dark h6 my-0">Logout</h6>
                                        </a>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>

                            <div class="widget mt-4 pt-2">
                                <h5 class="widget-title">Follow me :</h5>
                                <ul class="list-unstyled social-icon mb-0 mt-4">
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="github" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="youtube" class="fea icon-sm fea-social"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="gitlab" class="fea icon-sm fea-social"></i></a></li>
                                </ul><!--end icon-->
                            </div>
                        </div>
