
<!-- Hero Start -->
<section class="bg-half bg-blog  w-100 bg-info" style="background: url('<?php echo base_url('assets/main/images/account/bg.png');?>') center center;">
<div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                            <h4 class="title text-light"><?=$post->post_title;?></h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
</section><!--end section-->

    <section class="section  b-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                       

                        <p class="text-muted"><?php echo htmlspecialchars_decode(stripslashes($post->post_content)); ?></p>

                        </div>
                    </div>
                </div>
                
            </div>
            
        </section>
