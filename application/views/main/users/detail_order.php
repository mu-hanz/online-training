<section class="">
            <div class="container">
                <div class="row  pt-4 pt-sm-0 justify-content-center">
                    <div class="col-lg-12">
                        <div class="card shadow rounded border-0">
                            <div class="card-body">
                                <a href="<?=base_url('users/dashboard/order');?>" class="btn btn-secondary mlink"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back</a>      
                                <div class="invoice-middle py-4">
                                    <h5>Order Details :</h5>
                                    <div class="row mb-0">
                                        <div class="col-md-7 order-2 order-md-1">
                                            <dl class="row">
                                                <dt class="col-md-3 col-5 font-weight-normal">Order ID. : </dt>
                                                <dd class="col-md-9 col-7 text-muted"><?=$data_transaction->order_id;?></dd>
                                                
                                                <dt class="col-md-3 col-5 font-weight-normal">Name :</dt>
                                                <dd class="col-md-9 col-7 text-muted"><?=$data_transaction->first_name.' '.$data_transaction->last_name;?></dd>
                                                
                                                <dt class="col-md-3 col-5 font-weight-normal">Address :</dt>
                                                <dd class="col-md-9 col-7 text-muted">
                                                    <p class="mb-0" style="max-width: 300px;"><?=$data_transaction->company_address;?></p>
    
                                                </dd>
                                                
                                                <dt class="col-md-3 col-5 font-weight-normal">Phone :</dt>
                                                <dd class="col-md-9 col-7 text-muted"><?=$data_transaction->phone;?></dd>
                                            </dl>
                                        </div>
    
                                        <div class="col-md-5 order-md-2 order-1 mt-2 mt-sm-0">
                                            <dl class="row mb-0">
                                                <dt class="col-md-5 col-5 font-weight-normal">Date :</dt>
                                                <dd class="col-md-7 col-7 text-muted"><?=$data_transaction->created_date;?></dd>
                                                <dt class="col-md-5 col-5 font-weight-normal">Payment Type:</dt>
                                                <dd class="col-md-7 col-7 text-muted"><?=$data_transaction->payment_type;?></dd>
                                                <dt class="col-md-5 col-5 font-weight-normal">Status :</dt>
                                                <dd class="col-md-7 col-7 text-muted">
                                                <?php if($data_transaction->payment_status == 'paid' || $data_transaction->payment_status == 'settlement'){
                                                    $class = 'success';
                                                } else if ($data_transaction->payment_status == 'pending') {
                                                    $class = 'warning';
                                                } else {
                                                    $class = 'danger';
                                                } ?>  
                                                <span class="badge badge-<?=$class;?>"> <?=ucwords($data_transaction->payment_status);?> </span>
                                               </dd>
                                               <dt class="col-md-5 col-5 font-weight-normal">Payment Date:</dt>
                                                <dd class="col-md-7 col-7 text-muted"><?=$data_transaction->payment_date;?></dd>
                                                <?php if($data_transaction->payment_cancel_date != null){?>
                                                <dt class="col-md-5 col-5 font-weight-normal">Cancel Date:</dt>
                                                <dd class="col-md-7 col-7 text-muted"><?=$data_transaction->payment_cancel_date;?></dd>
                                                <?php } ?>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="invoice-table pb-4">
                                    <div class="table-responsive bg-white shadow rounded">
                                        <table class="table mb-0 table-center invoice-tb">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th scope="col" class="text-left">No.</th>
                                                    <th scope="col" class="text-left">Item</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Rate</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($list_order as $order){?>
                                                <tr>
                                                    <th scope="row" class="text-left"><?=$no;?></th>
                                                    <td class="text-left">
                                                        <strong class="text-primary"><?=$order->event_name;?></strong><br>
                                                        <?php if($order->event_type !== 'e-training' && $order->event_type !== 'in-house-training'){?>
                                                        <span class="text-info">[<?= date("d-m-Y H:i:s", strtotime($order->event_start_date))?> - <?= date("d-m-Y H:i:s", strtotime($order->event_end_date))?>]</span>
                                                        <?php } ?>
                                                        <?php if($order->event_type == 'e-training'){?>
                                                                <span class=" text-info">[Duration : <?php echo $order->event_duration;?>] </span><br>
                                                            <?php } ?>
                                                        <p class="mt-4">Data Peserta :</p>
                                                        <p>
                                                            <?php 
                                                                $list_peserta = $this->Dashboard_m->list_peserta($order->transaction_detail_id);
                                                            foreach($list_peserta as $peserta) {?>
                                                            <span class="badge badge-pill badge-outline-primary"> <?=$peserta->name;?> </span>
                                                            <?php } ?>
                                                        </p>
                                                        
                                                        <?php 
                                                        if($data_transaction->payment_status == 'paid'){
                                                            if($order->link_streaming != null || $order->link_streaming != '' ){?>
                                                        <p class="mt-4">Streaming/Zoom ID</p>
                                                        <dl class="row">
                                                            <dt class="col-md-3 col-5 font-weight-normal">Link : </dt>
                                                            <dd class="col-md-9 col-7 text-muted">
                                                            <button class="btn btn-soft-warning btn-sm copy_link" data-clipboard-text="<?=$order->link_streaming;?>">
                                                                Copy Link
                                                            </button>
                                                            </dd>
                                                            
                                                            <dt class="col-md-3 col-5 font-weight-normal">ID :</dt>
                                                            <dd class="col-md-9 col-7 text-muted"><?=$order->streaming_id;?></dd>
              
                                                            <dt class="col-md-3 col-5 font-weight-normal">Pass :</dt>
                                                            <dd class="col-md-9 col-7 text-muted"><?=$order->streaming_key;?></dd>
                                                        </dl>
                                                        <?php } } ?>
                                                    </td>
                                                    <td><?=$order->qty;?></td>
                                                    <td><?=rupiah_num($order->event_price);?></td>
                                                    <td><?=rupiah_num($order->event_price * $order->qty);?></td>
                                                </tr>
                                                <?php $no++; } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-lg-4 col-md-5 ml-auto">
                                            <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                                <li class="text-muted d-flex justify-content-between">Subtotal :<span><?php $sub = $data_transaction->subtotal - abs($data_transaction->discount_flexi); echo rupiah_num($sub);?></span></li>
                                                <?php if($data_transaction->discount_voucher > 0){?>
                                                <li class="text-muted d-flex justify-content-between">Voucher :<span class="text-danger"> <?=rupiah_num($data_transaction->discount_voucher);?></span></li>
                                                <?php } ?>
                                                <li class="d-flex justify-content-between">Total :<strong class="text-primary"><?=rupiah_num($data_transaction->total);?></strong></li>
                                            </ul>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section>