                        <style>.dataTables_wrapper .dataTables_paginate .paginate_button {padding:0px;}</style>
                        <div class="border-bottom pb-4 data-loading">

                            <h5 class="mt-4 mb-0">Members</h5>
                            <?php if ($page == 'index') { ?> 
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <input type="hidden" name="redirect_sweetalert" id="redirect_sweetalert" value="<?=$redirect_sweetalert;?>">
                                    <table id="datatable-responsive" class="responsive display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">Name</th>
                                                <th>Email</th>
                                                <th>Job</th>
                                                <th>Phone</th>
                                                <th data-priority="2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list_members as $row) { ?>
                                            <tr>
                                                <td><?=$row->name;?></td>
                                                <td><?=$row->email;?></td>
                                                <td><?=$row->job_title;?></td>
                                                <td><?=$row->phone;?></td>
                                                <td><a href="<?=base_url();?>members-edit/<?=$row->id_members;?>" class="btn btn-info btn-sm"><i data-feather="edit" class="fea icon-sm fea-social"></i></a> <a href="javascript:void(0)" class="btn btn-danger btn-sm del" term_id="<?=$row->id_members;?>" term_url="store/users/dashboard/delete_members"><i data-feather="trash-2" class="fea icon-sm fea-social"></i></a></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php } else { ?>
                            <form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" data-parsley-validate class="ajaxForm">
                                <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <input type="hidden" name="id" value="<?=$id_members;?>">
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Name</label>
                                            <i data-feather="user" class="fea icon-sm icons"></i>
                                            <input name="name" id="name" type="text" class="form-control pl-5" placeholder="Name :" value="<?=$name;?>">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Email</label>
                                            <i data-feather="mail" class="fea icon-sm icons"></i>
                                            <input name="email" id="email" type="email" class="form-control pl-5" placeholder="Email :" value="<?=$email;?>">
                                        </div>
                                    </div><!--end col-->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Job Title</label>
                                            <i data-feather="briefcase" class="fea icon-sm icons"></i>
                                            <input name="job_title" id="job_title" type="text" class="form-control pl-5" placeholder="Job Title :" value="<?=$job_title;?>">
                                        </div> 
                                    </div><!--end col-->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label>Phone</label>
                                            <i data-feather="phone" class="fea icon-sm icons"></i>
                                            <input name="phone" id="phone" type="text" class="form-control pl-5" placeholder="Phone :" value="<?=$phone;?>">
                                        </div> 
                                    </div><!--end col-->
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <input type="submit" id="submit" name="Save" class="btn btn-primary" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                            <?php } ?>
                        </div>

                        
               