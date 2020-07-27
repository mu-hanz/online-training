<!-- Start Content-->
<div class="container-fluid">
    <form role="form" id="form" class="ajaxForm" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
    <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row page-title align-items-center">
        <div class="col-xl-4 col-sm-12">
            <h4 class="mb-1 mt-0"><?php echo $title;?></h4>
        </div>
        <div class="col-xl-8 d-none d-md-block">
            <div class="form-inline float-sm-right mt-3 mt-sm-0">
            <?php if ($cancel): ?>
                <div class="form-group mb-sm-0 mr-2">
                    <input type="text" class="form-control" readonly="readonly" style="min-width:360px" value="Last Modifed: <?php echo ($data_content ? $data_content->post_modifed : "") ;?> - By: <?php echo $this->ion_auth->user()->row()->first_name;?>">
                </div>
            <?php endif;?>
            <?php if ($cancel): ?>
                <a href="<?php echo base_url('webadmin/posts/articles/list');?>"class="btn btn-danger mr-2 mlink">
                <i class="icon"><span data-feather="x"></span></i> Cancel
            </a>
            <?php endif;?>
                <button id="draft" type="submit" class="btn btn-secondary mr-2">
                <i class="icon"><span data-feather="coffee"></span></i> Save to Draft
                </button>
            
                <button type="submit" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i> <?php echo ($cancel ? 'Publish' : 'Save');?>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col">
                                <div class="form-group row mb-3">
                                    <label for="title" class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-11">
                                        <input type="text" class="form-control" id="title" name="post_title" value="<?php echo ($data_content ? $data_content->post_title : "") ;?>" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="Title" class="col-lg-1 col-form-label">Content</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" id="content" name="post_content" ><?php echo ($data_content ? $data_content->post_content : "") ;?></textarea>
                                    </div>
                                    <div class="col-lg-3 mt-sm-2">
                                        <div class="card mb-4">
                                            <div class="card-header text-center">
                                                <strong>Main Images</strong>
                                            </div>
                                            <div  id="overlay-cover" class="<?php echo ($data_content  && !empty($data_content->post_image) ? 'box-overlay' : '') ;?>">
                                                <img class="card-img-top img-fluid image-overlay" src="<?php echo ($data_content  && !empty($data_content->post_image) ? base_url($data_content->post_image) : base_url('assets/app/images/small/img-1.jpg')) ;?>" id="cover" width="100%">
                                                <input type="hidden" name="cover" id="post_cover" value="<?php echo ($data_content ? $data_content->post_image : "") ;?>">
                                                <div class="middle-overlay">
                                                    <a href="javascript:void(0);" class="delete-text remove-images" data-id="cover">Delete</a>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="card-body border-0 p-0">
                                                    <a href="javascript:void(0);" class="btn btn-light btn-block rounded-0 open_media" data-id="cover" data-toggle="modal" data-target="#modal-media">Choose / Upload</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-4">
                                            <div class="card-body p-0">
                                                <h5 class="header-title">Category</h5>
                                                <div class="slimscroll border-top" style="min-height: 210px;">
                                                    <?php foreach ($data_category as $category):
                                                        $checked = null;
                                                        foreach($data_category_current as $current) {
                                                            if ($category->term_taxonomy_id == $current->term_taxonomy_id) {
                                                                $checked= 'checked';
                                                            break;
                                                            }
                                                        }
                                                    ?>
                                                    <div class="custom-control custom-checkbox  mt-2">
                                                        <input type="checkbox" name="post_category[]" id="<?=$category->term_id;?>" value="<?=$category->term_id;?>" class="custom-control-input" <?=$checked;?>>
                                                        <label class="custom-control-label" for="<?=$category->term_id;?>"><?=$category->name;?></label>
                                                    </div>
                                                        <?php $data_term_parent = $this->Terms_m->get_terms('category-articles', $category->term_id)->result();
            
                                                            foreach($data_term_parent as $category_parent): 

                                                                $checked = null;
                                                                foreach($data_category_current as $current) {
                                                                    if ($category_parent->term_taxonomy_id == $current->term_taxonomy_id) {
                                                                        $checked= 'checked';
                                                                    break;
                                                                    }
                                                                }
                                                            ?>
                                                        <div class="custom-control custom-checkbox mt-2 ml-3">
                                                            <input type="checkbox" name="post_category[]" id="<?=$category_parent->term_id;?>"  value="<?=$category_parent->term_id;?>"  class="custom-control-input" <?=$checked;?>>
                                                            <label class="custom-control-label" for="<?=$category_parent->term_id;?>"><?=$category_parent->name;?></label>
                                                        </div>
                                                        <?php endforeach; ?>          
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="card-body p-0">
                                            <div class="custom-control custom-checkbox  mb-2">
                                                <input type="checkbox" name="scheduler" id="scheduler" class="custom-control-input" <?php echo ($data_content && $data_content->post_scheduler == 1 ? 'checked' : "") ;?>>
                                                <label class="custom-control-label" for="scheduler">Set Schedule Date</label>
                                            </div>
                                                <div class="form-group">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control datepicker text-center input_scheduler" name="date_schedule" value="<?php echo ($data_content  && $data_content->post_scheduler == 1 ? date("Y-m-d", strtotime($data_content->post_date)) : "") ;?>" <?php echo ($data_content && $data_content->post_scheduler == 0 ? 'disabled' : "") ;?>>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text border-left-0">-</div>
                                                        </div>
                                                        <input type="text" class="form-control time24 text-center input_scheduler"  name="time_schedule" value="<?php echo ($data_content  && $data_content->post_scheduler == 1 ? date("H:i", strtotime($data_content->post_date)) : "") ;?>" <?php echo ($data_content && $data_content->post_scheduler == 0 ? 'disabled' : "") ;?>>
                                                        <input type="hidden" name="scheduler_current" class="custom-control-input" value="<?php echo ($data_content ? $data_content->post_date : "") ;?>">
                                                    </div> 
                                                </div>                  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body text-right">
                <?php if ($cancel): ?>
                <a href="<?php echo base_url('webadmin/posts/articles/list');?>"class="btn btn-danger mr-2 mlink">
                <i class="icon"><span data-feather="x"></span></i> Cancel
                </a>
                <?php endif;?>
                <button id="draft" type="submit" class="btn btn-secondary mr-2">
                <i class="icon"><span data-feather="coffee"></span></i> Save to Draft
                </button>
            
                <button type="submit" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i> <?php echo ($cancel ? 'Publish' : 'Save');?>
                </button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <div class="modal fade" id="modal-media" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Media Library</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <iframe id="frame_media" src="" width="100%" height="550" style="border: 1px solid #eee;"></iframe>
                </div>                                                
            </div>
        </div>
    </div>  
</div> <!-- container-fluid -->