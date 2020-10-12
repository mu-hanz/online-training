
<!-- Hero Start -->
<section class="bg-half bg-cart d-table w-100 bg-primary" style="background: url('<?php echo base_url('assets/main/images/account/bg.png');?>') center center;">
<div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                            <h4 class="title text-light"> Order Cart </h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
                </section><!--end section-->
<!-- Start -->

<section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                     <?php  $cart = $this->cart->contents();  if(!empty($cart)): ?>
                        <div class="table-responsive bg-white shadow">
                            <table class="table table-center table-padding mb-0">
                                <thead>
                                    <tr>
                                        <th class="py-3" style="min-width: 300px;">Product</th>
                                        <th class="text-center py-3" style="min-width: 160px;">Price</th>
                                        <th class="text-center py-3" style="min-width: 160px;">Qty</th>
                                        <th class="text-center py-3" style="min-width: 160px;">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $used_voucher = false; foreach ($cart as $items):
                                        
                                        if($items['sku'] == 'voucher'):
                                            $used_voucher = true;
                                        ?>
                                        
                                        <tr id="event-<?php echo $items['rowid'];?>">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                <a><img src="<?php echo base_url('assets/main/images/voucher.png');?>" class="img-fluid avatar avatar-small rounded shadow" style="height:auto;" alt="<?php echo $items['name'];?>"></a>
                                                    <h6 class="mb-0 ml-3">Kode Voucher : <span class="text-success"><?php echo $items['name'];?></span></h6>
                                                </div>
                                            </td>
                                            <td class="text-center text-danger price-voucher"><?php echo rupiah($items['price']);?></td>
                                            <td class="text-center">
                                                <input type="button" data-id="<?php echo $items['rowid'];?>" value="x" class="remove-product btn btn-icon btn-soft-danger font-weight-bold">
                                            </td>
                                            <td class="text-center font-weight-bold text-danger  price-sub-voucher" id="<?php echo $items['rowid'];?>"><?php echo rupiah($items['subtotal']);?></td>
                                        </tr>

                                    <?php else:?>

                                        <tr id="event-<?php echo $items['rowid'];?>">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                <a href="<?= base_url($items['slug']);?>" class="mlink"><img src="<?php echo base_url($items['images']);?>" class="img-fluid avatar avatar-small rounded shadow" style="height:auto;" alt="<?php echo $items['name'];?>"></a>
                                                    <h6 class="mb-0 ml-3"><a href="<?= base_url($items['slug']);?>" class="text-success mlink"><?php echo $items['name'];?></a></h6>
                                                </div>
                                            </td>
                                            <td class="text-center"><?php echo rupiah($items['price']);?></td>
                                            <td class="text-center">
                                                <input type="button" data-id="<?php echo $items['rowid'];?>" value="-" class="minus btn btn-icon btn-soft-primary font-weight-bold">
                                                <input type="text" step="1" min="1" name="quantity" value="<?php echo $items['qty'];?>" title="Qty" class="btn btn-icon btn-soft-primary font-weight-bold" readonly>
                                                <input type="button" data-id="<?php echo $items['rowid'];?>" value="+" class="plus btn btn-icon btn-soft-primary font-weight-bold">
                                                <input type="button" data-id="<?php echo $items['rowid'];?>" value="x" class="remove-product btn btn-icon btn-soft-danger font-weight-bold">
                                            </td>
                                            <td class="text-center font-weight-bold" id="<?php echo $items['rowid'];?>"><?php echo rupiah($items['subtotal']);?></td>
                                        </tr>
                                    <?php endif; endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-lg-8 col-md-6 mt-4 pt-2">
                        <a href="j<?= base_url();?>" class="btn btn-primary"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>  Continue Order</a>
                        <a href="javascript:void(0)" class="btn btn-soft-primary ml-2 apply-coupon" <?php if($used_voucher){echo 'style="display:none"';}?>>Apply Coupon</a>
                    </div>
                    <div class="col-lg-4 col-md-6 ml-auto mt-4 pt-2">
                        <div class="table-responsive bg-white rounded shadow">
                            <table class="table table-center table-padding mb-0">
                                <tbody>
                                    <tr>
                                        <td class="h6">Subtotal</td>
                                        <td class="text-center font-weight-bold" id="total-cart"><?php echo rupiah($this->cart->total());?></td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pt-2 text-right">
                            <a href="shop-checkouts.html" class="btn btn-primary">Proceed to checkout</a>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <?php else:?>
                    <div class="card shadow rounded border-0 overflow-hidden">
                    <div class="card-body text-center">
                        <h5 class="card-title">Wah keranjang belanjaanmu kosong!</h5>
                        <p class="text-muted mb-0">Daripada dianggurin, mending isi dengan pelatihan impianmu. Yuk cek sekarang!</p>
                        <a href="<?php echo base_url('events/all-events');?>" class="btn btn-pills btn-primary mt-4 mlink"> Liat Rekomedasi Pelatihan </a>
                    </div>
                    </div> 
                <?php endif;?>
            </div><!--end container-->
        </section><!--end section-->
           
        <section class="section pt-4" id="courses">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Pelatihan yang paling diminati</h4>
                           
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <?php foreach($event_popular as $pop){?>

                        <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                        <div class="card blog rounded border-0 shadow overflow-hidden">
                            <div class="position-relative">
                                <img src="<?php echo base_url($pop->event_thumbs);?>" class="card-img-top" alt="<?=$pop->event_name;?>">
                                <div class="overlay bg-dark"></div>
                                <a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="mlink">
                                    <div class="course-fee bg-white text-center shadow-lg rounded-circle">
                                        <h6 class="text-primary font-weight-bold fee"><i data-feather="arrow-up-right" class="fea icon-md text-success"></i> </h6>
                                    </div>
                                </a>
                            </div>
                            <div class="position-relative">
                                <div class="shape overflow-hidden text-white" style="bottom: -3px;">
                                    <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body content">
                                <small><a href="javascript:void(0)" class="text-primary h6"><?=$pop->group_name;?></a></small>
                                <h5 class="mt-2"><a href="<?php echo base_url('events/detail/'.$pop->event_slug);?>" class="title text-dark mlink"><?=$pop->event_name;?></a></h5>
                                <ul class="list-unstyled d-flex justify-content-between border-top mt-3 pt-3 mb-0">
                                    <li class="text-muted small"><i data-feather="award" class="fea icon-sm text-info"></i> <?=$pop->cert_name;?></li>
                                    <li class="text-muted small ml-3"><i data-feather="bookmark" class="fea icon-sm text-warning"></i><?= string_type($pop->event_type);?></li>
                                </ul>
                            </div>
                        </div> <!--end card / course-blog-->
                    </div><!--end col-->

                    <?php }?>


                    <div class="col-12 mt-4 pt-2 text-center">
                        <a href="<?php echo base_url('events/all-events');?>" class="btn btn-primary mlink">See More Courses <i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div><!--end row-->
            </div><!--end container-->

            
        </section><!--end section-->
        <!-- End -->

        