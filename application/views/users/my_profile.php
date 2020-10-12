<div class="row">
                            <div class="col">
                                <div class="card mb-5">
                                    <div class="card-header border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0 text-success">Profil Saya</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Nama Depan</label>
                                                            <input type="text" class="form-control" name="first_name" value="<?php echo $user->first_name;?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Nama Belakang</label>
                                                            <input type="text" class="form-control" name="last_name" value="<?php echo $user->last_name;?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?php echo $user->email;?>" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Nomor HP</label>
                                                            <input type="number" class="form-control" name="phone" value="<?php echo $user->phone;?>" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Jabatan</label>
                                                            <input type="text" class="form-control" name="job_title" value="<?php echo $user->job_title;?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-danger">Ubah Password</label>
                                                            <input type="password" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                
                                                
                                                
                                            </div>

                                            <div class="col-lg-4">
                                            <label class="text-black  text-center">Foto Profile</label>
                                                <div class="add-item position-relative mb-2">
                                                    <div class="add-item-img d-flex justify-content-center border border-radius py-3">
                                                    <img src="<?php echo base_url('assets/app/images/users/avatar.jpg');?>" class="rounded-circle" alt="profile image">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" />
                                                        <label class="custom-file-label" for="inputGroupFile01">Pilih Gambar</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-header border-top">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0 text-success">Profil Perusahaan</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Nama Perusahaan</label>
                                                            <input type="text" class="form-control" name="company" value="<?php echo $user->company;?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Nomor NPWP (Optional)</label>
                                                            <input type="text" class="form-control" name="company_npwp" value="<?php echo $user->company_npwp;?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Alamat Peruhanaan</label>
                                                            <textarea class="form-control" rows="2" name="company_address"><?php echo $user->company_address;?></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-lg-4 align-self-center text-center">

                                            <div class="form-actions my-1">
                                            <button type="button" class="btn btn-success width-150">
                                                Update Profile
                                            </button>
                                            
                                        </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>