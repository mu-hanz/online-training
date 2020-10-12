
<div class="breadcrumb-wrap ">
                <div class="container py-3">
                    <div class="row d-flex justify-content-md-between justify-content-sm-center">
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb " style="display: flex;" >
                            <button type="button" id="sidebarCollapse" class="btn btn-secondary btn-sm mr-3 d-block d-sm-none"><i class="las la-bars"></i></button>
                                <ol class="breadcrumb mb-0 mz-link">
                                    <li class="breadcrumb-item mr-1 font-weight-bold  active" aria-current="page">Home</li>
                                    <?php if($this->uri->segment('3') != ''){?>
                                    <li class="breadcrumb-item ml-1 font-weight-bold active" aria-current="page">
                                        <?php echo ucwords(str_replace("_"," ",$this->uri->segment('3')));?>
                                    </li>
                                    <?php } ?>
                                    <?php if($this->uri->segment('4') != ''){?>
                                    <li class="breadcrumb-item ml-1 font-weight-bold active" aria-current="page">
                                    <?php echo ucwords(str_replace("_"," ",$this->uri->segment('4')));?>
                                    </li>
                                    <?php } ?>
                                    <?php if($this->uri->segment('5') != ''){?>
                                    <li class="breadcrumb-item ml-1 font-weight-bold active" aria-current="page">
                                    <?php echo ucwords(str_replace("_"," ",$this->uri->segment('5')));?>
                                    </li>
                                    <?php } ?>
                                </ol>
                            </nav>
                        </div>
                        <div class="header-actions d-none d-sm-block">
                            <button class="btn btn-ghost grey-dark font-weight-bold">
                            <i class="las la-calendar-check"></i>
                                <span>Join Date : <?php echo date('d-m-Y H:i:s', $user->created_on);?></span>
                            </button>
                            <button class="btn btn-ghost grey-dark like-button font-weight-bold">
                            <i class="las la-user-clock"></i>
                                <span>Last Login : <?php echo date('d-m-Y H:i:s', $user->last_login);?></span>
                            </button>
                            

                            <!---->
                        </div>
                    </div>
                </div>
            </div>
