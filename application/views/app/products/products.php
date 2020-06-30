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
                                <th>Product Name</th>
                                <th>Category</th>
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
    </div>
        <form role="form" id="form-ajax-datatable" class="ajaxForm needs-validation" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" novalidate>
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" id="folder" name="folder" value="<?=$folder;?>">
                        <input type="hidden" id="file" name="file" value="<?=$file;?>">
                        <input type="hidden" id="id_data" name="id_data" value="<?=$id_data;?>">
                        <input type="hidden" id="count_data_product_media_images" name="count_data_product_media_images" value="<?=$count_data_product_media_images;?>">
                        <input type="hidden" id="count_data_product_media_files" name="count_data_product_media_files" value="<?=$count_data_product_media_files;?>">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 well">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="promotionName">Product Name</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?=$product_name;?>" required>
                                            <div class="invalid-feedback">
                                                This value is required
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Product Description</label>
                                            <textarea id="summernote-editor" name="product_description" class="container-custom-summernote"><?=$product_description;?></textarea>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>   
                        
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#home" data-toggle="tab" aria-expanded="false"
                                    class="nav-link active">
                                    <span class="d-block d-sm-none"><i class="uil-home-alt"></i></span>
                                    <span class="d-none d-sm-block">Images</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <span class="d-block d-sm-none"><i class="uil-user"></i></span>
                                    <span class="d-none d-sm-block">Files</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#messages" data-toggle="tab" aria-expanded="false"
                                    class="nav-link">
                                    <span class="d-block d-sm-none"><i class="uil-envelope"></i></span>
                                    <span class="d-none d-sm-block">Messages</span>
                                </a>
                            </li> -->
                        </ul>
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane show active" id="home">
                                <div class="form-group row" id="inputFormRow">
                                    <div class="col-lg-8">
                                        <label for="promotionName">Image</label>
                                        <input type="file" class="form-control" name="file_image[]" id="example-fileinput">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="promotionName">Ordering</label>
                                        <input type="text" class="form-control" name="ordering_image[]" id="simpleinput">
                                    </div>
                                    <div class="col-lg-2 text-right">
                                        <button id="removeRow" type="button" class="btn btn-danger remove-btn-removeRow">Remove</button>
                                    </div>
                                </div>
                                <div id="newRow"></div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn--md btn-primary" id="addRow">Add Image</button>
                                        <small>*Allowed type file : jpg | jpeg | png | gif & Allowed size File : 2Mb</small>
                                    </div>
                                </div>
                                <?php if ($page == 'edit') { ?>
                                <div class="row">
                                    <?php
                                    $no = 1;
                                    foreach ($get_data_product_media_images as $row) {
                                    ?>
                                    <div class="col-lg-4" id="inputFormRowEdit<?=$no;?>">
                                        <img class="card-img-top img-fluid" src="<?=base_url();?>assets/app/images/products/<?=$row->product_media_name;?>" alt="Card image cap">
                                        <div class="row pt-2">
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="ordering_image_edit[]" value="<?=$row->ordering;?>" id="simpleinputEdit<?=$no;?>">
                                                <input type="hidden" name="product_media_id" id="product_media_image_id<?=$no;?>" value="<?=$row->product_media_id;?>">
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <button type="button" id="removeRowEdit<?=$no;?>" class="btn btn-danger">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="newRowEdit<?=$no;?>"></div>
                                    <?php $no++; } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane" id="profile">
                                <div class="form-group row" id="inputFormRowFile">
                                    <div class="col-lg-10">
                                        <label for="promotionName">File</label>
                                        <input type="file" class="form-control" name="file_upload[]" id="example-fileinput">
                                    </div>
                                    <!-- <div class="col-lg-2">
                                        <label for="promotionName">Ordering</label>
                                        <input type="text" class="form-control" name="ordering_file[]" id="simpleinput">
                                    </div> -->
                                    <div class="col-lg-2 text-right">
                                        <button id="removeRowFile" type="button" class="btn btn-danger remove-btn-removeRow">Remove</button>
                                    </div>
                                </div>
                                <div id="newRowFile"></div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn--md btn-primary" id="addRowFile">Add File</button>
                                    </div>
                                </div>
                                <?php if ($page == 'edit') { ?>
                                <?php
                                $no = 1;
                                foreach ($get_data_product_media_files as $row) {
                                ?>
                                <div class="row mt-2" id="inputFormRowFileEdit<?=$no;?>">
                                    <div class="col-lg-8">
                                        <i data-feather="file" class="icon-dual"></i> <a href="<?=base_url();?>assets/app/files/products/<?=$row->product_media_name;?>" target="_blank"><?=base_url();?>assets/app/files/products/<?=$row->product_media_name;?></a>
                                        <input type="hidden" name="product_media_id" id="product_media_file_id<?=$no;?>" value="<?=$row->product_media_id;?>">
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <button id="removeRowFileEdit<?=$no;?>" type="button" class="btn btn-danger">Remove</button>
                                    </div>
                                </div>
                                <div id="newRowFileEdit<?=$no;?>"></div>
                                <?php $no++; } ?>
                                <?php } ?>
                            </div>
                            <!-- <div class="tab-pane" id="messages">
                                &nbsp;
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pt-2 pb-3">
                        <h6 class="header-title">Publish</h6>
                        <div class="border-top border-bottom">
                            <div class="row mt-2">
                                <div class="col">
                                    <label>
                                    <i data-feather="user" class="icon-dual"></i> Created by
                                    </label>
                                </div>
                                <div class="col">
                                    <?php if ($page == 'create') { ?>
                                    : -    
                                    <?php } else { ?>
                                    : <?=$username;?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>
                                    <i data-feather="eye" class="icon-dual"></i> Views
                                    </label>
                                </div>
                                <div class="col">
                                    <?php if ($page == 'create') { ?>
                                    : -
                                    <?php } else { ?>
                                    : <?=$views;?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>
                                    <i data-feather="calendar" class="icon-dual"></i> Date :
                                    </label>
                                </div>
                                <div class="col">
                                    <?php if ($page == 'create') { ?>
                                    : -
                                    <?php } else { ?>
                                    : <?php echo date("d-m-Y", strtotime($edited_date));?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>
                                    <i data-feather="archive" class="icon-dual"></i> Status :
                                    </label>
                                </div>
                                <div class="col"> 
                                    <select class="custom-select mb-2" id="custom-select1" name="status" required>
                                        <?php if ($page == 'create') { ?>
                                            <option value=""></option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Draft">Draft</option>
                                        <?php } else { ?>
                                            <option value="<?=$status;?>"><?=$status;?></option>
                                            <?php if ($status == 'Aktif') { ?> <?php } else { ?> <option value="Aktif">Aktif</option> <?php } ?> 
                                            <?php if ($status == 'Draft') { ?> <?php } else { ?> <option value="Draft">Draft</option> <?php } ?> 
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        This value is required
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 text-right">
                                <a href="<?=base_url();?>webadmin/<?=$folder;?>/<?=$file;?>" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pt-2 pb-3">
                        <h5 class="header-title">Category</h5>
                        <div class="slimscroll border-top" style="max-height: 390px;">
                            <?php
                            $no = 1;
                            $checked = '';
                            foreach ($get_data_category as $row) {
                                if ($page == 'create') {
                                    $checked = '';
                                } else {
                                    if ($row->term_id == $category_id) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                }
                            ?>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio<?=$no;?>" name="category_id" class="custom-control-input" value="<?=$row->term_id;?>" <?=$checked;?> required>
                                        <label class="custom-control-label" for="customRadio<?=$no;?>"><?=$row->name;?></label>
                                    </div>
                                    <div class="invalid-feedback">
                                        This value is required
                                    </div>
                                </div>
                            </div>
                            <?php $no++; } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php } ?>
    </div>
</div>