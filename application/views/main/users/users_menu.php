                        <div class="sidebar sticky-bar p-4 rounded shadow">
                            
                            <div class="widget">
                                <div class="row">
                                    <div class="col-12 mt-4 pt-2">
                                        <a href="<?=base_url('users/dashboard');?>" class="accounts <?php  echo ($this->uri->segment('3') == '' ? 'active' : '') ?> rounded d-block shadow text-center py-3">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-dashboard"></i></span>
                                            <h6 class="title text-dark h6 my-0">Dashboard</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <a href="<?=base_url('users/dashboard/order');?>" class="accounts rounded d-block shadow text-center py-3 <?php  echo ($this->uri->segment('3') == 'order' || $this->uri->segment('3') == 'detail_order' ? 'active' : '') ?>">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-shopping-bag"></i></span>
                                            <h6 class="title text-dark h6 my-0">My Order</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <a href="<?=base_url('users/dashboard/participant');?>" class="accounts <?php  echo ($this->uri->segment('3') == 'participant' || $this->uri->segment('3') == 'edit_participant' ? 'active' : '') ?> rounded d-block shadow text-center py-3">
                                        <span class="pro-icons h3 text-muted"><i class="uil uil-users-alt"></i></span>
                                        <h6 class="title text-dark h6 my-0">Participants</h6>
                                        </a>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <a href="<?=base_url('users/dashboard/profile');?>" class="accounts rounded d-block shadow text-center py-3 <?php  echo ($this->uri->segment('3') == '' ? 'profile' : '') ?>">
                                            <span class="pro-icons h3 text-muted"><i class="uil uil-sliders-v-alt"></i></span>
                                            <h6 class="title text-dark h6 my-0">My Account</h6>
                                        </a>
                                    </div><!--end col-->

                                    
                                </div><!--end row-->
                            </div>
                        </div>
