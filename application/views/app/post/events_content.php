<!-- Start Content-->
<div class="container-fluid">
    <div class="row page-title align-items-center">
        <div class="col-xl-6 col-sm-12">
            <h4 class="mb-1 mt-0"><?php echo $title;?></h4>
        </div>
        <div class="col-xl-6 d-none d-md-block">
            <div class="form-inline float-sm-right mt-3 mt-sm-0">
                <div class="form-group mb-sm-0 mr-2">
                    <input type="text" class="form-control" readonly="readonly" style="min-width:240px" value="Created in <?php echo date('d M Y H:i:s', now());?>">
                </div>
                <button type="button" class="btn btn-secondary mr-2">
                <i class="icon"><span data-feather="coffee"></span></i> Save to Draft
                </button>
                <button type="button" class="btn btn-primary" >
                <i class="icon"><span data-feather="check-circle"></span></i> Save
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col">
                                <div class="form-group row mb-3">
                                    <label for="title" class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-11">
                                        <input type="email" class="form-control" id="title" name="title">
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="Title" class="col-lg-1 col-form-label">Content</label>
                                    <div class="col-lg-8">
                                    <textarea class="form-control" id="content" name="content"></textarea>
                                    </div>
                                    
                                    <div class="col-lg-3 mt-sm-2">
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
                    </form>
                </div>
            </div>
        </div>
    </div>

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