 <!-- Start Content-->
 <div class="container-fluid">
                        <div class="row page-title mt-2 d-print-none">
                            <div class="col-md-12">
                                <nav aria-label="breadcrumb" class="float-right mt-1">
                                <?php echo $this->breadcrumbs->show();?>
                                </nav>
                                <h4 class="mb-1 mt-0"><?=$title;?></h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Logo & title -->
                                        <div class="clearfix">
                                            <div class="float-sm-right">
                                            <a href="<?php echo base_url('webadmin/orders/orders');?>"class="btn btn-secondary mr-2 mlink">
                                                    <i class="icon"><span data-feather="corner-up-left"></span></i> Back
                                                </a>
                                            </div>
                                            <div class="float-sm-left">
                                                <h4 class="m-0 d-print-none">Invoice</h4>
                                                <dl class="row mb-2 mt-3">
                                                    <dt class="col-sm-4 font-weight-normal">Invoice Number :</dt>
                                                    <dd class="col-sm-8 font-weight-normal"><?=$data_transaction->order_id;?></dd>

                                                    <dt class="col-sm-4 font-weight-normal">Invoice Date :</dt>
                                                    <dd class="col-sm-8 font-weight-normal"><?=$data_transaction->created_date;?></dd>
                                                </dl>
                                            </div>
                                            
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <h6 class="font-weight-normal">Invoice For:</h6>
                                                <h6 class="font-size-16"><?=$data_transaction->first_name.' '.$data_transaction->last_name;?></h6>
                                                <address>
                                                <?=$data_transaction->company_address;?><br>
                                                   
                                                    <abbr title="Phone">P:</abbr> <?=$data_transaction->phone;?>
                                                </address>
                                            </div> <!-- end col -->

                                            <div class="col-md-6">
                                                <div class="text-md-right">
                                                    <h6 class="font-weight-normal">Total</h6>
                                                    <h2><?=rupiah($data_transaction->total);?></h2>
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table mt-4 table-centered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Item</th>
                                                                <th style="width: 10%">Qty</th>
                                                                <th style="width: 10%">Rate</th>
                                                                <th style="width: 10%" class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $no=1; foreach($list_order as $order){?>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>
                                                                    <h5 class="font-size-16 mt-0 mb-2"><?=$order->event_name;?></h5>
                                                                    <p class="text-muted mb-0">[<?= date("d-m-Y H:i:s", strtotime($order->event_start_date))?> - <?= date("d-m-Y H:i:s", strtotime($order->event_end_date))?>]</p>
                                                                    <h5 class="font-size-16 mt-4 mb-2">Data Peserta:</h5>
                                                                    <table class="table mt-4">
                                                                        <thead>
                                                                            <tr class="table-active">
                                                                                <th>No</th>
                                                                                <th>Nama</th>
                                                                                <th>Email</th>
                                                                                <th>No Hp</th>
                                                                                <th>Jabatan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                        <?php  $noo = 1;
                                                                            $list_peserta = $this->orders_m->list_peserta($order->transaction_detail_id);
                                                                            foreach($list_peserta as $peserta) {?>
                                                                            <tr class="table-active">
                                                                                <td><?=$noo;?></td>
                                                                                <td><?=$peserta->name;?></td>
                                                                                <td><?=$peserta->email;?></td>
                                                                                <td><?=$peserta->phone;?></td>
                                                                                <td><?=$peserta->job_title;?></td>
                                                                            </tr>
                                                                            <?php $noo++; } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                                <td><?=$order->qty;?></td>
                                                                <td><?=rupiah_num($order->event_price);?></td>
                                                                <td class="text-right"><?=rupiah_num($order->event_price * $order->qty);?></td>
                                                            </tr>
                                                            <?php $no++; } ?>
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end table-responsive -->
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="clearfix pt-5">
                                            
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-sm-6">
                                                <div class="float-right mt-4">
                                                    <p><span class="font-weight-medium">Subtotal:</span> <span
                                                            class="float-right"><?php $sub = $data_transaction->subtotal - abs($data_transaction->discount_flexi); echo rupiah_num($sub);?></span></p>
                                                            <?php if($data_transaction->discount_voucher > 0){?>
                                                            <p><span class="font-weight-medium">Discount Voucher:</span> <span
                                                            class="float-right"> &nbsp;&nbsp;&nbsp; <?=rupiah_num($data_transaction->discount_voucher);?></span></p>
                                                            <?php } ?>
                                                    <h3><?=rupiah($data_transaction->total);?></h3>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->

                                        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->