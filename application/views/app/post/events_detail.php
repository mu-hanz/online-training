<!-- Start Content-->
<div class="container-fluid">
    <form role="form" id="form" class="ajaxForm" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
    <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row page-title align-items-center">
        <div class="col-xl-6 col-sm-12">
            <h4 class="mb-1 mt-0"><?php echo $title;?></h4>
        </div>
        <div class="col-xl-6 d-none d-md-block">
            <div class="form-inline float-sm-right mt-3 mt-sm-0">
                <button id="createnew" type="submit" class="btn btn-secondary mr-2">
                <i class="icon"><span data-feather="coffee"></span></i> Publish and Create New
                </button>
                <button type="submit" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i> Publish
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
                                    <label for="title" class="col-lg-1 col-form-label">Content</label>
                                    <div class="col-lg-11">
                                        <select data-plugin="customselect" class="form-control" data-placeholder="Select Content Event" name="post_content">
                                            <option></option>
                                            <?php foreach($data_content as $content):?>
                                                <option value="<?php echo $content->id_post;?>" data-thumbs="<?php echo $content->post_thumbs;?>" data-cover="<?php echo $content->post_image;?>" data-title="<?php echo $content->post_title;?>"><?php echo $content->post_title;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-11">
                                        <input type="text" class="form-control" id="title" name="event_name">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="subtitle" class="col-lg-1 col-form-label">Subtitle</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="subtitle" name="event_subtitle">
                                    </div>
                                    <label for="sku" class="col-lg-1 col-form-label text-lg-center">Sku</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="sku" name="event_sku">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Group</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectGroup" class="form-control" data-placeholder="Select Group" name="group_id">
                                            <option></option>
                                            <?php foreach($data_group as $data):?>
                                                <option value="<?php echo $data->term_id;?>" data-group="<?php echo $data->name;?>"><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                            
                                        </select>
                                        <input type="hidden" id="group" name="group_id_name">
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label text-lg-center">Certificate</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselect" class="form-control" data-placeholder="Select Certificate" name="certificate_id">
                                            <option></option>
                                            <?php foreach($data_certificate as $data):?>
                                                <option value="<?php echo $data->term_id;?>"><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label text-lg-center">Category</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselect" class="form-control" data-placeholder="Select Category"  name="category_id">
                                            <option></option>
                                            <?php foreach($data_category as $data):?>
                                                <option value="<?php echo $data->term_id;?>"><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Regional</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectRegional" class="form-control" data-placeholder="Select Regional" name="regional_id">
                                            <option></option>
                                            <?php foreach($data_regional as $data):?>
                                                <option value="<?php echo $data->term_id;?>" data-regional="<?php echo $data->name;?>"><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <input type="hidden" id="regional" name="regional_id_name">
                                    </div>
                                    <label class="col-lg-1 col-form-label text-lg-center">Location</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselect" class="form-control" data-placeholder="Select Location" name="location_id">
                                            <option></option>
                                            <?php foreach($data_location as $data):?>
                                                <option value="<?php echo $data->term_id;?>"><?php echo $data->name;?> ( <?php echo $data->description;?> )</option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label text-lg-center">Type</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectType" class="form-control" data-placeholder="Select Type" name="type_id">
                                            <option></option>
                                            <?php foreach($data_type as $data):?>
                                                <option value="<?php echo $data->term_id;?>" data-training="<?php echo $data->name;?>"><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <input type="hidden" id="type" name="type_id_name">
                                    </div>
                                </div>
                                <div class="urlStreaming" style="display:none">
                                    <div class="form-group row mb-3">
                                        <label for="title" class="col-lg-1 col-form-label">Link Stream</label>
                                        <div class="col-lg-11">
                                            <input type="text" class="form-control" name="link_streaming" placeholder="Ex : https://.zoom.us">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="title" class="col-lg-1 col-form-label">ID Meeting</label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" name="streaming_id">
                                        </div>
                                        <label for="title" class="col-lg-1 col-form-label text-lg-center">Password</label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" name="streaming_key">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="title" class="col-lg-1 col-form-label">Images</label>
                                    <div class="col-lg-2">
                                        <div class="card mb-4">
                                            <div class="card-header text-center">
                                                <strong>Main Images</strong>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="" id="overlay-cover">
                                                    <img class="card-img-top img-fluid image-overlay" src="<?php echo base_url('assets/app/images/small/img-1.jpg');?>" id="cover" width="100%">
                                                    <input type="hidden" name="cover" id="post_cover" value="">
                                                    <div class="middle-overlay">
                                                        <a href="javascript:void(0);" class="delete-text remove-images" data-id="cover">Delete</a>
                                                    </div>
                                                </div>
                                                <div class="card-body border-0 p-0">
                                                    <a href="javascript:void(0);" class="btn btn-light btn-block rounded-0 open_media" data-id="cover" data-toggle="modal" data-target="#modal-media">Choose / Upload</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="card mb-4">
                                            <div class="card-header text-center">
                                                <strong>Thumbs Images</strong>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="" id="overlay-thumbs">
                                                    <img class="card-img-top img-fluid image-overlay" src="<?php echo base_url('assets/app/images/small/img-1.jpg');?>" id="thumbs" width="100%">
                                                    <input type="hidden" name="thumbs" id="post_thumbs" value="">
                                                    <div class="middle-overlay">
                                                        <a href="javascript:void(0);" class="delete-text remove-images" data-id="thumbs">Delete</a>
                                                    </div>
                                                </div>
                                                <div class="card-body border-0 p-0">
                                                    <a href="javascript:void(0);" class="btn btn-light btn-block rounded-0 open_media" data-id="thumbs" data-toggle="modal" data-target="#modal-media">Choose / Upload</a>
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
                <div class="card-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col">
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Event Cost</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="event_cost">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Cost Promo</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="event_cost_promo">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Start Date</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control datepicker" name="event_start_date">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control time24"  name="event_start_time">
                                        </div>
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label">End Date</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control datepicker"  name="event_end_date">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control time24"  name="event_end_time">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                <label for="title" class="col-lg-1 col-form-label">Duration</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" placeholder="Ex : 2 Days"  name="event_duration">
                                    </div>
                                <label for="Title" class="col-lg-1 col-form-label">Schedule</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control datepicker" name="schedule_date">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control time24"  name="schedule_time" >
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
                <button id="createnew" type="submit" class="btn btn-secondary mr-2">
                <i class="icon"><span data-feather="coffee"></span></i> Publish and Create New
                </button>
                <button type="submit" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i> Publish
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