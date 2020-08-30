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
                                <th>Flexi Combo Name</th>
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
                                            <?php
                                            $subfile = str_replace('_', ' ', $file);
                                            ?>
                                            <small class="d-block">Setup <?=ucwords($subfile);?></small>
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
                                            <label for="promotionName">Promotion Name</label>
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
                                            <input type="text" id="datetime-datepicker2" class="form-control flatpickr-input" name="end_date" value="<?=$end_date;?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Promotion Valid On</label>
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
                                        <div class="form-group col-md-3">
                                            <label>Usage Limit Promotion</label>
                                            <input type="text" class="form-control" value="<?=$limit_promotion;?>" name="limit_promotion" required>
                                            <div class="invalid-feedback">
                                                This value is required
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Usage Limit User</label>
                                            <input type="text" class="form-control" value="<?=$limit_user;?>" name="limit_user" required>
                                            <div class="invalid-feedback">
                                                This value is required
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Usage Limit User Referral</label>
                                            <input type="text" class="form-control" value="<?=$limit_user_referral;?>" name="limit_user_referral">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Type Discounted For Next User Referral</label>
                                            <select class="custom-select mb-2" name="type_discount_referral">
                                                <?php
                                                if ($page == 'create') {
                                                ?>
                                                    <option value=""></option>
                                                    <option value="Flat">Flat</option>
                                                    <option value="Accumulation">Accumulation</option>
                                                    <option value="Custom">Custom</option>
                                                <?php } else { ?>
                                                    <option selected="<?=$type_discount_referral;?>"><?=$type_discount_referral;?></option>
                                                    <?php if ($type_discount_referral == 'Flat') { ?>
                                                        <option value="Accumulation">Accumulation</option>
                                                        <option value="Custom">Custom</option>
                                                    <?php } else if ($type_discount_referral == 'Accumulation') { ?>
                                                        <option value="Flat">Flat</option>
                                                        <option value="Custom">Custom</option>
                                                    <?php } else { ?>
                                                        <option value="Flat">Flat</option>
                                                        <option value="Accumulation">Accumulation</option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row container-discount-referral" id="field_amount_discount_referral">
                                        <?php if ($page == 'create') { ?>
                                        <div class="form-group col-md-6">
                                            <label for="promotionName">Amount Discount For Next User Referral <span id="number-referral">1</span></label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">IDR</div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroupxx1" name="amount_discount_referral[]">
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <input type="hidden" name="count_data_promotions_type_referral" id="count_data_promotions_type_referral" value="<?=$count_data_promotions_type_referral;?>">
                                        <?php
                                        $xx = 1; 
                                        foreach ($promotions_type_referral as $row) {
                                        ?>
                                        <div class="form-group col-md-6" id="divreferral_<?=$xx;?>">
                                            <label for="promotionName">Amount Discount For Next User Referral <span id="number-referral"><?=$xx;?></span></label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">IDR</div>
                                                </div>
                                                <input type="text" class="form-control" id="inlineFormInputGroupxx1" value="<?=number_format($row->amount_discount_referral);?>" name="amount_discount_referral[]">
                                            </div>
                                        </div>
                                        <?php $xx++; } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="row container-tier">  
                                        <input type="hidden" name="max_field_tiers" id="max_field_tiers" value="<?=$max_field_tiers;?>">
                                        <input type="hidden" name="count_data_promotions_tier" id="count_data_promotions_tier" <?php if ($page == 'create') { ?> value="1" <?php } else { ?> value="<?=$count_data_promotions_tier;?>" <?php } ?>>
                                        <?php
                                        if ($page == 'create') {
                                        ?> 
                                        <div class="form-group col-md-12 element-tier" id='div_1'>
                                            <label>Promotion Tiers (Max <?=$max_field_tiers;?> Tier) </label>
                                            <div class="card card-promotion-tiers-custom">
                                                <div class="header-card-promotion-tiers-custom">
                                                    <div class="float-right container-button-add-tier">
                                                        <div class="btn btn-danger btn-sm mt-2 button-remove-tier">Remove Tier</div>
                                                        <div id="button-add-tier" class="btn btn-primary btn-sm mt-2">
                                                            Add Tier
                                                        </div>
                                                    </div>
                                                    <div class="float-left">
                                                        <span class="mb-4">Tier 1 <input type="hidden" name="name_tier1" value="Tier 1"></span>
                                                    </div>
                                                    <div class="clearfix">&nbsp;</div>
                                                </div>
                                                <div class="card-body pt-2 pb-3">
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-0">
                                                            <label for="promotionName">Promotion Criteria</label>
                                                            <p class="sub-header mb-2">
                                                                Diskon dapat diakumulasikan dalam 1 order (Misalnya dengan promosi "Beli 100.000 Diskon 30.000", jika membeli 300.000 maka potongan nya (300.000/100.000 x 30.000) = 90.000
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadio1" name="customRadio1" value="criteria_qty" class="customRadio1 custom-control-input">
                                                                <label class="custom-control-label" for="customRadio1">Amount Of Training >=</label>
                                                            </div>
                                                            <input type="text" class="form-control criteria_qty1" name="criteria_qty1" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadio1_2" name="customRadio1" value="criteria_price" class="customRadio1 custom-control-input">
                                                                <label class="custom-control-label" for="customRadio1_2">Transaction Value >=</label>
                                                            </div>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">IDR</div>
                                                                </div>
                                                                <input type="text" class="form-control criteria_price1" id="inlineFormInputGroup1" name="criteria_price1" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-0">
                                                            <label for="promotionName">Discount</label>
                                                            <p class="sub-header mb-2">
                                                                Diskon akan diberikan jika kriteria promosi tercapai
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 mb-0">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadiox1" name="customRadiox1" class="customRadiox1 custom-control-input" value="discount_percent">
                                                                <label class="custom-control-label" for="customRadiox1">Discount Percentage</label>
                                                            </div>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">% Off</div>
                                                                </div>
                                                                <input type="text" class="form-control discount_percent1" name="discount_percent1" id="inlineFormInputGroup" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-0">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadiox1_2" name="customRadiox1" class="customRadiox1 custom-control-input" value="discount_price">
                                                                <label class="custom-control-label" for="customRadiox1_2">Discounts</label>
                                                            </div>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">IDR</div>
                                                                </div>
                                                                <input type="text" class="form-control discount_price1" name="discount_price1" id="inlineFormInputGroupx1" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else if ($page == 'edit') { ?>
                                        <?php
                                        $x = 1; 
                                        foreach ($promotions_tier as $row) {
                                        ?>
                                        <div class="form-group col-md-12 element-tier" id='div_<?=$x;?>'>
                                            <?php if ($row->name_tier == 'Tier 1') { ?>
                                            <label>Promotion Tiers (Max <?=$max_field_tiers;?> Tier) </label>
                                            <?php } ?>
                                            <div class="card card-promotion-tiers-custom">
                                                <div class="header-card-promotion-tiers-custom">
                                                    <div class="float-right container-button-add-tier">
                                                        <?php
                                                        if ($x == '1') {
                                                        ?>
                                                        <div class="btn btn-danger btn-sm mt-2 button-remove-tier">Remove Tier</div>
                                                        <div id="button-add-tier" class="btn btn-primary btn-sm mt-2">
                                                            Add Tier
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="float-left mb-3">
                                                        <span class="mb-4"><?=$row->name_tier;?> <input type="hidden" name="name_tier1" value="Tier 1"></span>
                                                    </div>
                                                    <div class="clearfix">&nbsp;</div>
                                                </div>
                                                <div class="card-body pt-2 pb-3">
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-0">
                                                            <label for="promotionName">Promotion Criteria</label>
                                                            <p class="sub-header mb-2">
                                                                Diskon dapat diakumulasikan dalam 1 order (Misalnya dengan promosi "Beli 100.000 Diskon 30.000", jika membeli 300.000 maka potongan nya (300.000/100.000 x 30.000) = 90.000
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                        if ($row->criteria_qty != '0' && $row->criteria_qty != '')  {
                                                            $checked_criteria_qty   = 'checked';
                                                            $disabled_criteria_qty  = '';
                                                        } else {
                                                            $checked_criteria_qty   = '';
                                                            $disabled_criteria_qty  = 'disabled';
                                                        }
                                                        ?>
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadio<?=$x;?>" name="customRadio<?=$x;?>" value="criteria_qty" class="customRadio<?=$x;?> custom-control-input" <?=$checked_criteria_qty;?>>
                                                                <label class="custom-control-label" for="customRadio<?=$x;?>">Amount Of Training >=</label>
                                                            </div>
                                                            <?php
                                                            if ($row->criteria_qty == '0' OR $row->criteria_qty == '') {
                                                                $criteria_qty = '';
                                                            } else {
                                                                $criteria_qty = $row->criteria_qty;
                                                            } ?>
                                                            <input type="text" class="form-control criteria_qty<?=$x;?>" name="criteria_qty<?=$x;?>" value="<?=$criteria_qty;?>" <?=$disabled_criteria_qty;?>>
                                                        </div>
                                                        <?php
                                                        if ($row->criteria_price != '0' && $row->criteria_price != '')  {
                                                            $checked_criteria_price   = 'checked';
                                                            $disabled_criteria_price  = '';
                                                        } else {
                                                            $checked_criteria_price   = '';
                                                            $disabled_criteria_price  = 'disabled';
                                                        }
                                                        ?>
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadio<?=$x;?>_2" name="customRadio<?=$x;?>" value="criteria_price" class="customRadio<?=$x;?> custom-control-input" <?=$checked_criteria_price;?>>
                                                                <label class="custom-control-label" for="customRadio<?=$x;?>_2">Transaction Value >=</label>
                                                            </div>
                                                            <?php
                                                            if ($row->criteria_price == '0' OR $row->criteria_price == '') {
                                                                $criteria_price = '';
                                                            } else {
                                                                $criteria_price = number_format($row->criteria_price);
                                                            } ?>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">IDR</div>
                                                                </div>
                                                                <input type="text" class="form-control criteria_price<?=$x;?>" id="inlineFormInputGroup<?=$x;?>" name="criteria_price<?=$x;?>" value="<?=$criteria_price;?>" <?=$disabled_criteria_price;?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-0">
                                                            <label for="promotionName">Discount</label>
                                                            <p class="sub-header mb-2">
                                                                Diskon akan diberikan jika kriteria promosi tercapai
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                        if ($row->discount_percent != '0' && $row->discount_percent != '')  {
                                                            $checked_discount_percent   = 'checked';
                                                            $disabled_discount_percent  = '';
                                                        } else {
                                                            $checked_discount_percent   = '';
                                                            $disabled_discount_percent  = 'disabled';
                                                        }
                                                        ?>
                                                        <div class="form-group col-md-6 mb-0">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadiox<?=$x;?>" name="customRadiox<?=$x;?>" class="customRadiox<?=$x;?> custom-control-input" value="discount_percent" <?=$checked_discount_percent;?>>
                                                                <label class="custom-control-label" for="customRadiox<?=$x;?>">Discount Percentage</label>
                                                            </div>
                                                            <?php
                                                            if ($row->discount_percent == '0' OR $row->discount_percent == '') {
                                                                $discount_percent = '';
                                                            } else {
                                                                $discount_percent = $row->discount_percent;
                                                            } ?>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">% Off</div>
                                                                </div>
                                                                <input type="text" class="form-control discount_percent<?=$x;?>" name="discount_percent<?=$x;?>" value="<?=$discount_percent;?>" id="inlineFormInputGroup" <?=$disabled_discount_percent;?>>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($row->discount_price != '0' && $row->discount_price != '')  {
                                                            $checked_discount_price   = 'checked';
                                                            $disabled_discount_price  = '';
                                                        } else {
                                                            $checked_discount_price   = '';
                                                            $disabled_discount_price  = 'disabled';
                                                        }
                                                        ?>
                                                        <div class="form-group col-md-6 mb-0">
                                                            <div class="custom-control custom-radio mb-2">
                                                                <input type="radio" id="customRadiox<?=$x;?>_2" name="customRadiox<?=$x;?>" class="customRadiox<?=$x;?> custom-control-input" value="discount_price" <?=$checked_discount_price;?>>
                                                                <label class="custom-control-label" for="customRadiox<?=$x;?>_2">Discounts</label>
                                                            </div>
                                                            <?php
                                                            if ($row->discount_price == '0' OR $row->discount_price == '') {
                                                                $discount_price = '';
                                                            } else {
                                                                $discount_price = number_format($row->discount_price);
                                                            } ?>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">IDR</div>
                                                                </div>
                                                                <input type="text" class="form-control discount_price<?=$x;?>" name="discount_price<?=$x;?>" value="<?=$discount_price;?>" id="inlineFormInputGroupx<?=$x;?>" <?=$disabled_discount_price;?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $x++; } ?>
                                        <?php } ?>
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
                                                <table id="basic-datatable" class="table w-100">
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
                                                            <th>Cost</th>
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
                                                            <td>
                                                                <?php
                                                                if ($row->event_cost_promo != '0' OR $row->event_cost_promo != '') {
                                                                ?>
                                                                    <s>IDR <?=number_format($row->event_cost);?></s><br>
                                                                    IDR <?=number_format($row->event_cost_promo);?>
                                                                <?php } else { ?>
                                                                    IDR <?=number_format($row->event_cost);?>
                                                                <?php } ?>
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