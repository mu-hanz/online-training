<!-- Start Content-->
<div class="container-fluid">
    <form role="form" id="form" class="ajaxForm  needs-validation" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
    <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row page-title align-items-center">
        <div class="col-xl-6 col-sm-12">
            <h4 class="mb-1 mt-0"><?php echo $title;?></h4>
        </div>
        <div class="col-xl-6 d-none d-md-block">
            <div class="form-inline float-sm-right mt-3 mt-sm-0">
            <?php if ($cancel):?>
                    <a href="<?php echo base_url('webadmin/posts/events/list_event');?>"class="btn btn-danger mr-2 mlink">
                        <i class="icon"><span data-feather="x"></span></i> Cancel
                    </a>
                <?php else:?>
                    <button id="createnew" type="submit" class="btn btn-secondary mr-2">
                    <i class="icon"><span data-feather="coffee"></span></i> Publish and Create New
                    </button>
                <?php endif;?>
                <button type="submit" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i>  <?php echo ($cancel ? 'Update' : 'Publish');?>
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
                                        <select data-plugin="customselect" class="form-control" data-placeholder="Select Content Event" name="post_content"  required>
                                            <option></option>
                                            <?php foreach($data_content as $content):?>
                                                <option value="<?php echo $content->id_post;?>" data-thumbs="<?php echo $content->post_thumbs;?>" data-cover="<?php echo $content->post_image;?>" data-title="<?php echo $content->post_title;?>" <?php echo ($data_event && $content->id_post ==  $data_event->post_id) ? 'selected' : "" ;?>><?php echo $content->post_title;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="invalid-feedback">
                                            This value is required
                                        </div> 
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="title" name="event_name"  value="<?php echo ($data_event ? $data_event->event_name : "") ;?>" required>
                                        <div class="invalid-feedback">
                                            This value is required
                                        </div> 
                                    </div>
                                    <label class="col-lg-1 col-form-label text-lg-center">Register</label>
                                    <div class="col-lg-3">
                                        <div class="custom-control custom-switch  mt-2">
                                            <?php if($data_event){?>
                                            <input type="checkbox" name="event_register" class="custom-control-input" id="reg_enable" value="<?php echo $data_event->event_register;?>" <?php echo ($data_event->event_register ==  '0') ? 'checked' : "" ;?>>
                                            <label class="custom-control-label <?php echo ($data_event->event_register ==  '1') ? 'text-muted' : "" ;?>" id="reg_enable_text" for="reg_enable"><?php echo ($data_event->event_register ==  '0') ? 'Enabled Register' : "Disabled Register" ;?></label>
                                            <?php } else { ?>
                                            <input type="checkbox" name="event_register" class="custom-control-input" id="reg_enable" value="0" checked>
                                            <label class="custom-control-label" id="reg_enable_text" for="reg_enable">Enabled Register</label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="subtitle" class="col-lg-1 col-form-label">Subtitle</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="subtitle" name="event_subtitle" value="<?php echo ($data_event ? $data_event->event_subtitle : "") ;?>" required>
                                    </div>
                                    <label for="sku" class="col-lg-1 col-form-label text-lg-center">Sku</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="sku" name="event_sku" value="<?php echo ($data_event ? $data_event->event_sku : strtoupper("TCID-".random_string('nozero', 5))) ;?>" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Group</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectGroup" class="form-control" data-placeholder="Select Group" name="group_id"  required>
                                            <option></option>
                                            <?php foreach($data_group as $data):?>
                                                <option value="<?php echo $data->term_id;?>" data-group="<?php echo $data->name;?>" <?php echo ($data_event && $data->term_id ==  $data_event->group_id) ? 'selected' : "" ;?>><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                            
                                        </select>
                                        <input type="hidden" id="event_group" class="form-control" name="event_group_name">
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label text-lg-center">Certificate</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectRegional" class="form-control" data-placeholder="Select Certificate" name="certificate_id" required>
                                            <option></option>
                                            <?php foreach($data_certificate as $data):?>
                                                <option value="<?php echo $data->term_id;?>" <?php echo ($data_event && $data->term_id ==  $data_event->certificate_id) ? 'selected' : "" ;?>><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <input type="hidden" id="event_regional" class="form-control" name="event_regional_name">
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label text-lg-center">Category</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectone" class="form-control" data-placeholder="Select Category"  name="category_id">
                                            <option></option>
                                            <?php foreach($data_category as $data):?>
                                                <option value="<?php echo $data->term_id;?>" <?php echo ($data_event && $data->term_id ==  $data_event->category_id) ? 'selected' : "" ;?>><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Regional</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectone" class="form-control" data-placeholder="Select Regional" name="regional_id">
                                            <option></option>
                                            <?php foreach($data_regional as $data):?>
                                                <option value="<?php echo $data->term_id;?>" data-regional="<?php echo $data->name;?>" <?php echo ($data_event && $data->term_id ==  $data_event->regional_id) ? 'selected' : "" ;?>><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <label class="col-lg-1 col-form-label text-lg-center">Location</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectone" class="form-control" data-placeholder="Select Location" name="location_id" >
                                            <option></option>
                                            <?php foreach($data_location as $data):?>
                                                <option value="<?php echo $data->term_id;?>" <?php echo ($data_event && $data->term_id ==  $data_event->location_id) ? 'selected' : "" ;?>><?php echo $data->name;?> ( <?php echo $data->description;?> )</option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label text-lg-center">Type</label>
                                    <div class="col-lg-3">
                                        <select data-plugin="customselectType" class="form-control" data-placeholder="Select Type" name="type_id" required>
                                            <option></option>
                                            <?php foreach($data_type as $data):?>
                                                <option value="<?php echo $data->term_id;?>" data-slug="<?php echo $data->slug;?>" data-training="<?php echo $data->name;?>" <?php echo ($data_event && $data->term_id ==  $data_event->type_id) ? 'selected' : "" ;?>><?php echo $data->name;?></option>
                                            <?php endforeach;?>
                                        </select>

                                        <input type="hidden" id="event_type" class="form-control" name="event_type" value="<?php echo ($data_event ? $data_event->event_type : "") ;?>">
                                    </div>
                                </div>
                                <div class="urlStreaming" <?php echo ($data_event && $data_event->type_id == '11') ? '' : 'style="display:none"' ;?>>
                                    <div class="form-group row mb-3">
                                        <label for="title" class="col-lg-1 col-form-label">Link Stream</label>
                                        <div class="col-lg-11">
                                            <input type="text" class="form-control meeting" name="link_streaming" placeholder="Ex : https://.zoom.us" value="<?php echo ($data_event ? $data_event->link_streaming : "") ;?>">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="title" class="col-lg-1 col-form-label">ID Meeting</label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control meeting" name="streaming_id" value="<?php echo ($data_event ? $data_event->streaming_id : "") ;?>">
                                        </div>
                                        <label for="title" class="col-lg-1 col-form-label text-lg-center">Password</label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control meeting" name="streaming_key" value="<?php echo ($data_event ? $data_event->streaming_key : "") ;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="title" class="col-lg-1 col-form-label">Media</label>
                                    <div class="col-lg-2">
                                        <div class="card mb-4">
                                            <div class="card-header text-center">
                                                <strong>Main Images</strong>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="<?php echo ($data_event  && !empty($data_event->event_images) ? 'box-overlay' : '') ;?>" id="overlay-cover">
                                                    <img class="card-img-top img-fluid image-overlay" src="<?php echo ($data_event && !empty($data_event->event_images)  ? $data_event->event_images : base_url('assets/app/images/small/img-1.jpg')) ;?>" id="cover" width="100%">
                                                    <input type="hidden" name="cover" id="post_cover" value="<?php echo ($data_event ? $data_event->event_images : "") ;?>">
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
                                                <div class="<?php echo ($data_event  && !empty($data_event->event_thumbs) ? 'box-overlay' : '') ;?>" id="overlay-thumbs">
                                                    <img class="card-img-top img-fluid image-overlay" src="<?php echo ($data_event && !empty($data_event->event_thumbs)  ? $data_event->event_thumbs : base_url('assets/app/images/small/img-1.jpg')) ;?>" id="thumbs" width="100%">
                                                    <input type="hidden" name="thumbs" id="post_thumbs" value="<?php echo ($data_event ? $data_event->event_thumbs : "") ;?>">
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
                                    <div class="col-lg-7">
                                        <div class="card mb-4">
                                            <div class="card-header text-center">
                                                <strong>Embed Video Youtube</strong>
                                            </div>
                                            <div class="card-body p-0">
                                               <textarea name="event_video" class="form-control" rows="6" name="event_video"><?php echo ($data_event ? $data_event->event_video : "") ;?></textarea>
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
                                        <input type="text" class="form-control" name="event_cost" value="<?php echo ($data_event ? $data_event->event_cost : "") ;?>" required>
                                    </div>
                                    <label class="col-lg-1 col-form-label">Cost Promo</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="event_cost_promo" value="<?php echo ($data_event ? $data_event->event_cost_promo : "") ;?>" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Duration</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="event_duration" value="<?php echo ($data_event ? $data_event->event_duration : "") ;?>">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Max User</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="event_max_participant" value="<?php echo ($data_event ? $data_event->event_max_participant : "100") ;?>" placeholder="Default 100" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-lg-1 col-form-label">Event Date</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control text-center"  id="datepickerStart" name="event_start_date" value="<?php echo ($data_event && $data_event->event_start_date != '0000-00-00' ? $data_event->event_start_date : "") ;?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control text-center"  id="timepickerStart"  name="event_start_time" value="<?php echo ($data_event && $data_event->event_start_time != '00:00:00' ? $data_event->event_start_time : "") ;?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0"><a href="javascript:void(0);" id="cleardateStart">Clear</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <label for="Title" class="col-lg-1 col-form-label">End Date</label>
                                    <div class="col-lg-5">
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control text-center"  id="datepickerEnd" name="event_end_date" value="<?php echo ($data_event && $data_event->event_start_date != '0000-00-00' ? $data_event->event_end_date : "") ;?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control text-center"  id="timepickerEnd" name="event_end_time" value="<?php echo ($data_event && $data_event->event_end_time != '00:00:00' ? $data_event->event_end_time : "") ;?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0"><a href="javascript:void(0);" id="cleardateEnd">Clear</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                <label for="title" class="col-lg-1 col-form-label">Reg Close</label>
                                <div class="col-lg-5">
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control text-center" id="datepickerReg" name="event_close_date" value="<?php echo ($data_event ? $data_event->event_close_date : "") ;?>"  required>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control text-center" id="timepickerReg"  name="event_close_time"  value="<?php echo ($data_event ? $data_event->event_close_time : "") ;?>"  required>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0"><a href="javascript:void(0);" id="cleardateReg">Clear</a></div>
                                            </div>
                                        </div>
                                    </div>
                                <label for="Title" class="col-lg-1 col-form-label"><?php echo ($data_event && $data_event->event_schedule == 0 ? 'Publish On' : "Schedule") ;?></label>
                                <div class="col-lg-5">
                                    <?php if($data_event && $data_event->event_schedule == 0):?>
                                        <input type="text" class="form-control text-center" value="<?php echo $data_event->event_schedule_date ;?>" readonly>
                                    <?php else:?>
                                    
                                        <div class="input-group mb-2">
                                        <input type="text" class="form-control text-center"  id="datepickerSC" name="schedule_date" value="<?php echo ($data_event ? date('Y-m-d', strtotime($data_event->event_schedule_date)) : "") ;?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0">Time</div>
                                            </div>
                                            <input type="text" class="form-control text-center" id="timepickerSC" name="schedule_time"  value="<?php echo ($data_event ? date('H:i', strtotime($data_event->event_schedule_date)) : "") ;?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-left-0"><a href="javascript:void(0);" id="cleardateSC">Clear</a></div>
                                            </div>
                                        </div>
                                    <?php endif;?>
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
                <?php if ($cancel):?>
                    <a href="<?php echo base_url('webadmin/posts/events/list_event');?>"class="btn btn-danger mr-2 mlink">
                        <i class="icon"><span data-feather="x"></span></i> Cancel
                    </a>
                <?php else:?>
                    <button id="createnew" type="submit" class="btn btn-secondary mr-2">
                    <i class="icon"><span data-feather="coffee"></span></i> Publish and Create New
                    </button>
                <?php endif;?>
                <button type="submit" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i> <?php echo ($cancel ? 'Update' : 'Publish');?>
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