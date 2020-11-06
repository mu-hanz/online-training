                        <?php if($user->active == 0){?>
                        <div class="border-bottom pb-4">
                            <div class="alert alert-danger alert-pills mb-0 mt-3" role="alert">
                                <span class="badge badge-pill badge-light"> Action Required </span>
                                <span class="alert-content mr-5"> Email kamu belum di verfikasi silahkan konfirmasi sekarang </span>
                                <a href="<?php echo base_url('users/email_activation');?>"><span class="badge badge-pill badge-dark"> Konfirmasi Email Saya </span></a>
                            </div> 
                        </div>
                        <?php } ?>

                        <?php if($user->phone == null){?>
                        <div class="border-bottom pb-4">
                            <div class="alert alert-danger alert-pills mb-0 mt-3" role="alert">
                                <span class="badge badge-pill badge-light"> Complete Your Profile </span>
                                <span class="alert-content mr-5"> Silahkan lengkapi data profil kamu! </span>
                                <a href="<?php echo base_url('users/profile');?>"><span class="badge badge-pill badge-dark"> Edit Profil </span></a>
                            </div> 
                        </div>
                        <?php } ?>

                        
                        <div class="border-bottom pb-4">
                            <div class="row">
                                <div class="col-lg-12">
                                <?php //echo '<pre>',print_r($last_order,1),'</pre>';?>
                                <div class="table-responsive bg-white shadow rounded">
                            <table class="table mb-0 table-center">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" style="min-width: 300px;">Last Order</th>
                                        <th scope="col" class="text-center" style="max-width: 150px;">Status</th>
                                        <th scope="col" class="text-center" style="width: 100px;">Person</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if(is_array($last_order) && count($last_order)>0){
                                
                                    foreach ($last_order as $order){
                                ?>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <i class="uil uil-notes text-muted h4"></i>
                                                <div class="content ml-3">
                                                    <a href="<?=base_url('users/dashboard/detail_order/'.$order->transaction_id);?>" class="forum-title text-primary font-weight-bold">Order No. <?=$order->order_id;?></a>
                                                    <?php $detail_order = $this->Dashboard_m->get_order_users_detail($order->transaction_id);
                                                        foreach($detail_order as $detail){ ?>
                                                            <p class="text-muted small mb-0 mt-2">
                                                            <span class="text-primary h5 mr-2 d-none d-sm-inline-block"><span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em"><path class="uim-primary" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path><path class="uim-tertiary" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path></svg></span></span>
                                                            <a href="<?=base_url($detail->event_slug);?>" class="mlink"><?= $detail->event_name;?></a> <strong> x <?= $detail->qty;?></strong><br>
                                                            <?php if($detail->event_type !== 'e-training' && $detail->event_type !== 'in-house-training'){?>
                                                            <span class="ml-md-4 ml-sm-0 pl-md-2 pl-sm-0 text-info">[<?= date("d-m-Y H:i:s", strtotime($detail->event_start_date))?> - <?= date("d-m-Y H:i:s", strtotime($detail->event_end_date))?>]</span>
                                                            <?php } ?>
                                                            <?php if($detail->event_type == 'e-training'){?>
                                                                <span class="ml-md-4 ml-sm-0 pl-md-2 pl-sm-0 text-info">[Duration : <?php echo $detail->event_duration;?>] </span><br>
                                                            <?php } ?>
                                                            </p>
                                                            <div class="border-top ml-md-4 ml-sm-0 pl-md-2 pl-sm-0 my-2"></div>

                                                    <?php } ?>
                                                    <div class="ml-md-4 ml-sm-0 pl-md-2 pl-sm-0">
                                                        <a href="<?=base_url('users/dashboard/detail_order/'.$order->transaction_id);?>" class="mb-2 btn btn-soft-primary btn-sm mlink">View Detail </a>
                                                        <?php if($order->invoice_pdf == null || $order->invoice_pdf == ''){?>
                                                        <a href="<?=base_url('users/dashboard/create_invoice/'.$order->transaction_id);?>" class="mb-2 btn btn-soft-secondary btn-sm"> Donwload Invoice </a>
                                                        <?php } else { ?>
                                                            <a href="<?=base_url('media/invoice/'.$order->order_id);?>" class="btn btn-soft-secondary btn-sm"> Donwload Invoice </a>
                                                        <?php } ?>
                                                        <?php if($order->payment_status == 'unpaid'){ ?>
                                               
                                                            <button class="mb-2 btn btn-info btn-sm payAjax" data-id="<?=$order->transaction_id;?>">Pay Now</button>
                                                       
                                                        <?php } ?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center small h6">
                                        <?php if($order->payment_status == 'paid' || $order->payment_status == 'settlement'){
                                            $class = 'text-success';
                                        } else if ($order->payment_status == 'pending') {
                                            $class = 'text-warning';
                                        } else {
                                            $class = 'text-danger';
                                        } ?>
                                        <span class="<?=$class;?>"><?= ucwords($order->payment_status);?></span>

                                        <?php if($order->payment_status == 'cancel'){ ?>
                                            <br><span class="<?=$class;?>"><?= date("d-m-Y H:i:s", strtotime($order->payment_cancel_date)); ?></span> 
                                        <?php } ?>

                                        <div class="border-top my-2"></div>
                                        <strong class="text-success"><?php echo rupiah($order->total);?> </strong>
                                        </td>
                                        <td class="text-center small"><?=$order->person;?> </td>
                                    </tr>
                                <?php  } } else { ?>

                                <tr>
                                        <td colspan="3" class="text-center">
                                          
                                        <h5 class="card-title">Wah kamu masih belum melakukan order!</h5>
                                                <p class="text-muted mb-0">Daripada diliatin, mending isi dengan pelatihan impianmu. Yuk cek sekarang!</p>
                                                <a href="<?=base_url('/events/all-events');?>" class="btn btn-pills btn-primary mt-4 mlink"> Liat Rekomedasi Pelatihan </a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                <?php } ?>
                                 
                                </tbody>
                            </table>
                        </div>
                                </div><!--end col-->
                            </div>

                        </div>

                        
               