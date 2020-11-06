<!-- Topbar Start -->
<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="<?php echo base_url('webadmin');?>" class="navbar-brand mr-0 mr-md-2 logo mlink">
            <span class="logo-lg">
                <img src="<?php echo base_url('assets/app/images/'.($this->input->cookie('themes') == 'dark' ? 'logo-dark.png' : 'logo.png'));?>" alt="" height="24" />
                <span class="d-inline h5 ml-1 text-logo"><?php echo $this->config->item('system_name');?></span>
            </span>
            <span class="logo-sm">
                <img src="<?php echo base_url('assets/app/images/logo.png');?>" alt="" height="24">
            </span>
        </a>

        <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
            <li class="">
                <button class="button-menu-mobile open-left disable-btn">
                    <i data-feather="menu" class="menu-icon"></i>
                    <i data-feather="x" class="close-icon"></i>
                </button>
            </li>
        </ul>

        <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
            <li class="d-none d-sm-block">
                <div class="app-search mr-4 pr-3">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span data-feather="search"></span>
                        </div>
                    </form>
                </div>
            </li>
            <li class="dropdown notification-list">
                <a class="nav-link right-bar-toggle ml-2">
                    <div class="custom-control custom-switch nav-link">
                        <input type="checkbox" class="custom-control-input changeThemes" id="switchThemes" <?php echo ($this->input->cookie('themes') == 'dark' ? 'checked' : '');?>>
                        <label class="custom-control-label" for="switchThemes" style="display:inline"><?php echo ($this->input->cookie('themes') == 'dark' ? 'Light <span class="d-none d-md-inline">Mode</span>' : 'Dark <span class="d-none d-md-inline">Mode</span>');?></label>
                    </div>
                </a>
            </li>

            <li class="dropdown notification-list align-self-center profile-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <div class="media user-profile ">
                        <img src="<?php echo base_url('assets/app/images/users/avatar.jpg');?>" alt="user-image" class="rounded-circle align-self-center" />
                        <div class="media-body text-left">
                            <h6 class="pro-user-name ml-2 my-0">
                                <span>Muhamad Hanafi</span>
                                <span class="pro-user-desc text-muted d-block mt-1">Administrator </span>
                            </h6>
                        </div>
                        <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
                    </div>
                </a>
                <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                        <span>My Account</span>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i data-feather="help-circle" class="icon-dual icon-xs mr-2"></i>
                        <span>Support</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a href="<?php echo base_url('webadmin/auth/auth/logout');?>" class="dropdown-item notify-item">
                        <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- end Topbar -->