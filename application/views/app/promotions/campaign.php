<!-- Start Content-->
<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1 breadcrumb">
                 <?php echo $this->breadcrumbs->show();?>
            </nav>
            <h4 class="mb-1 mt-0"><?php echo $title;?></h4>
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="page" id="page" value="<?=$page;?>">
        <?php
        if ($page == 'index') {
        ?>
        <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <input type="hidden" id="folder" name="folder" value="<?=$folder;?>">
        <input type="hidden" id="file" name="file" value="<?=$file;?>">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="border-bottom pb-3 mb-3 text-right">
                        <a href="<?=base_url();?>webadmin/<?=$folder;?>/<?=$file;?>/create" class="btn btn-primary">
                            <i class="uil uil-file-plus-alt ml-1"></i> Add Data
                        </a>
                    </div>
                    <table id="basic-datatable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Campaign Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="body-row">
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form role="form" id="form-ajax-datatable" class="ajaxForm needs-validation" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" novalidate>
                        <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" id="folder" name="folder" value="<?=$folder;?>">
                        <input type="hidden" id="file" name="file" value="<?=$file;?>">
                        <input type="hidden" id="id_data" name="id_data" value="<?=$id_data;?>">
                        <div class="container container-fw-custom">
                            <div class="row form-group">
                                <div class="col-xs-12 header-fw-custom">
                                    <ul class="nav nav-pills nav-justified thumbnail setup-panel nav-pills-custom">
                                        <li class="active"><a href="#step-1">
                                            Step 1
                                            <small class="d-block">Setup <?=ucwords($file);?></small>
                                        </a></li>
                                        <li class="disabled"><a href="#step-2">
                                            Step 2
                                            <small class="d-block">Choice Training</small>
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row setup-content row-fw-custom" id="step-1">
                                <div class="col-md-12 well">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="promotionName">Campaign Name</label>
                                            <input type="text" class="form-control" id="promotions_name" name="promotions_name" value="<?=$promotions_name;?>" required>
                                            <div class="invalid-feedback">
                                                This value is required
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="datetime-datepicker">Start Date</label>
                                            <input type="text" id="datetime-datepicker" class="form-control flatpickr-input" name="start_date" value="<?=$start_date;?>" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>End Date</label>
                                            <input type="text" id="datetime-datepicker2" class="form-control flatpickr-input" name="end_date" value="<?=$end_date;?>" readonly="readonly" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Campaign Valid On</label>
                                            <select class="custom-select mb-2" id="custom-select1" name="valid_on" required>
                                                <?php
                                                if ($page == 'create') {
                                                ?>
                                                <option value=""></option>
                                                <option value="All Training">All Training</option>
                                                <option value="Training">Training</option>
                                                <?php } else { ?>
                                                    <?php if ($valid_on == 'All Training') { ?>
                                                        <option value="<?=$valid_on;?>" selected="selected"><?=$valid_on;?></option>
                                                        <option value="Training">Training</option>
                                                    <?php } else { ?>
                                                        <option value="<?=$valid_on;?>" selected="selected"><?=$valid_on;?></option>
                                                        <option value="All Training">All Training</option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                This value is required
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Campaign Banner</label>
                                            <input type="file" class="form-control" name="promotions_image" id="example-fileinput">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <?php
                                            if ($page == 'create') {
                                            ?>
                                            <img src="<?=base_url();?>assets/app/images/promotions/default_campaign_banner.jpg" >
                                            <?php } else { ?>
                                                <?php
                                                if ($promotions_image == '') {
                                                ?>
                                                    <img src="<?=base_url();?>assets/app/images/promotions/default_campaign_banner.jpg" >
                                                <?php } else { ?>
                                                    <img src="<?=base_url();?>assets/app/images/promotions/<?=$promotions_image;?>" >
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Campaign Content</label>
                                            <textarea id="summernote-editor" name="contents" class="container-custom-summernote"><?=$promotions_content;?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 text-right">
                                            <a href="<?=base_url();?>webadmin/<?=$folder;?>/<?=$file;?>" class="btn btn-danger">Cancel</a>
                                            <button id="activate-step-2" class="btn btn-primary">Next</button>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row setup-content row-fw-custom" id="step-2">
                                <div class="col-md-12 well">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive show-table">
                                                <input type="hidden" name="count_data_training" id="count_data_training" value="<?=$count_data_training;?>">
                                                <table id="basic-datatable" class="table w-100 table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <?php
                                                                if ($valid_on == 'All Training') {
                                                                    $checked_all = 'checked';
                                                                } else {
                                                                    $checked_all = '';
                                                                }
                                                                ?>
                                                                <div class="custom-control custom-switch mb-2">
                                                                    <input type="checkbox" class="custom-control-input example-select-all" name="select_all" value="1" id="customSwitchx" <?=$checked_all;?>>
                                                                    <label class="custom-control-label" for="customSwitchx">&nbsp;</label>
                                                                </div>
                                                            </th>
                                                            <th>Title</th>
                                                            <th>Price</th>
                                                            <th>Price Campaign</th>
                                                            <th>Location</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $xx = '1';
                                                        foreach ($get_data_training as $row) {
                                                        ?>
                                                            <?php if ($page != 'create') {
                                                                $checked        = '';
                                                                $price_campaign = '';
                                                                foreach ($get_data_training_detail as $row2) {
                                                                    if ($row->event_id === $row2->event_id) {
                                                                        $checked        = 'checked';
                                                                        $price_campaign = number_format($row2->price_campaign);
                                                                        break;
                                                                    } else {
                                                                        $checked        = '';
                                                                        $price_campaign = '';
                                                                    }
                                                                }
                                                            } else {
                                                                $checked        = '';
                                                                $price_campaign = '';
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <div class="custom-control custom-switch mb-2">
                                                                    <input type="checkbox" class="custom-control-input check-training" name="id<?=$xx;?>" value="<?=$row->event_id;?>" id="customSwitch<?=$xx;?>" <?=$checked;?>>
                                                                    <label class="custom-control-label" for="customSwitch<?=$xx;?>">&nbsp;</label>
                                                                </div>
                                                            </td>
                                                            <td><?=$row->post_title;?></td>
                                                            <td>IDR <?=number_format($row->event_cost);?></td>
                                                            <td>
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">IDR</div>
                                                                    </div>
                                                                    <input type="text" id="price-campaign<?=$xx;?>" class="form-control" value="<?=$price_campaign;?>" name="price_campaign<?=$xx;?>">
                                                                </div>
                                                            </td>
                                                            <td><?=$row->name;?></td>
                                                        </tr>
                                                        <?php $xx++; } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 text-right mt-4">
                                            <button id="back-step-1" class="btn btn-warning">Back</button>
                                            <input type="submit" class="btn btn-primary" value="Save">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <?php } ?>
    </div>
</div>