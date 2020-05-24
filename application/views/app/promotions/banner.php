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
        if ($page == 'index' OR $page == 'edit') {
        ?>
        <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <input type="hidden" id="folder" name="folder" value="<?=$folder;?>">
        <input type="hidden" id="file" name="file" value="<?=$file;?>">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <?php
                    if ($page == 'index') {
                    ?>
                    <h6 class="mb-3 header-title">Create <?=ucwords($file);?></h6>
                    <?php } else { ?>
                    <h5 class="mb-4 header-title">Edit <?=ucwords($file);?></h5>
                    <?php } ?>
                    <form role="form" id="form-ajax-datatable" class="ajaxForm needs-validation" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" novalidate>
                        <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" id="folder" name="folder" value="<?=$folder;?>">
                        <input type="hidden" id="file" name="file" value="<?=$file;?>">
                        <input type="hidden" id="id_data" name="id_data" value="<?=$id_data;?>">
                        <div class="row setup-content border-top pt-2">
                            <div class="form-group col-md-12">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?=$title_slider;?>" required>
                                <div class="invalid-feedback">
                                    This value is required
                                </div>
                            </div>  
                            <div class="form-group col-md-12">
                                <label>Position</label>
                                <select class="custom-select mb-2" id="custom-select1" name="position" required>
                                    <?php
                                    if ($page == 'index') {
                                    ?>
                                    <option value=""></option>
                                    <option value="Header">Header</option>
                                    <option value="Side Banner">Side Banner</option>
                                    <option value="Article">Article</option>
                                    <option value="Footer">Footer</option>
                                    <?php } else { ?>
                                        <?php if ($position == 'Header') { ?>
                                            <option value="<?=$position;?>" selected="selected"><?=$position;?></option>
                                            <option value="Side Banner">Side Banner</option>
                                            <option value="Article">Article</option>
                                            <option value="Footer">Footer</option>
                                        <?php } else if ($position == 'Side Banner') { ?>
                                            <option value="<?=$position;?>" selected="selected"><?=$position;?></option>
                                            <option value="Header">Header</option>
                                            <option value="Article">Article</option>
                                            <option value="Footer">Footer</option>
                                        <?php } else if ($position == 'Article') { ?>
                                            <option value="<?=$position;?>" selected="selected"><?=$position;?></option>
                                            <option value="Header">Header</option>
                                            <option value="Side Banner">Side Banner</option>
                                            <option value="Footer">Footer</option>
                                        <?php } else if ($position == 'Footer') { ?>
                                            <option value="<?=$position;?>" selected="selected"><?=$position;?></option>
                                            <option value="Header">Header</option>
                                            <option value="Side Banner">Side Banner</option>
                                            <option value="Article">Article</option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                    This value is required
                                </div>
                            </div>  
                            <div class="form-group col-md-12">
                                <label for="sorting">Sorting</label>
                                <input type="text" class="form-control" id="sorting" name="sorting" value="<?=$sorting;?>" required>
                                <div class="invalid-feedback">
                                    This value is required
                                </div>
                            </div>    
                            <div class="form-group col-md-12">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image" id="example-fileinput">
                            </div>
                            <div class="form-group col-md-12">
                                <?php
                                if ($page == 'index') {
                                ?>
                                <img src="<?=base_url();?>assets/app/images/promotions/default_campaign_banner.jpg" class="img-responsive" width="100%" >
                                <?php } else { ?>
                                    <?php
                                    if ($image == '') {
                                    ?>
                                        <img src="<?=base_url();?>assets/app/images/promotions/default_campaign_banner.jpg" class="img-responsive" width="100%" >
                                    <?php } else { ?>
                                        <img src="<?=base_url();?>assets/app/images/promotions/<?=$image;?>" class="img-responsive" width="100%" >
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="url">Url</label>
                                <input type="text" class="form-control" id="url" name="url" value="<?=$url;?>" required>
                                <div class="invalid-feedback">
                                    This value is required
                                </div>
                            </div>  
                            <div class="form-group col-md-6">
                                <label for="datetime-datepicker">Start Date</label>
                                <input type="text" id="datetime-datepicker" class="form-control flatpickr-input" name="start_date" value="<?=$start_date;?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>End Date</label>
                                <input type="text" id="datetime-datepicker2" class="form-control flatpickr-input" name="end_date" value="<?=$end_date;?>" readonly="readonly" required>
                            </div> 
                            <div class="form-group col-md-12 text-right mt-1">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Sorting</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="body-row">
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>