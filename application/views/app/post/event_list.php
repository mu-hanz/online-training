<!-- Start Content-->
<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1 breadcrumb">
                 <?php echo $this->breadcrumbs->show();?>
            </nav>
            <h4 class="mb-1 mt-0"><?php echo $title;?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

                <div class="table-responsive show-table">
                    <table id="datatable" class="table table-hover data-list-view">
                        <thead>
                        <tr>
                            <th width="200px">Name</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th width="35px">Count</th>
                        </tr>
                        </thead>
                        <tbody class="body-row">
                            <tr>
                                <td class="p-0">
                                    <img class="card-img-top img-fluid" src="<?php echo base_url('assets/app/images/small/img-1.jpg');?>" id="thumbs" width="50%">
                                </td>
                                <td class="pt-1 pb-1">
                                    <div class="row">
                                        <div class="col-lg-8 mb-2">
                                            <strong>Nama event <i>(VT)</i></strong><br>
                                            SKU : <i>Subtutle</i>
                                        </div>
                                        <div class="col-lg-6">
                                        Type : dasdasd<br>
                                        Group : dasdasd
                                        </div>
                                        <div class="col-lg-6">
                                        Certificate : dasdasd<br>
                                        Regional : dasdasd
                                        </div>
                                        <div class="col-lg-6">
                                            Category : dasdasd
                                        </div>
                                            <div class="col-lg-6">
                                            Location : dasdasd
                                        </div>
                                    </div>
                                    
                                   

                                </td>
                                <td  class="pt-1 pb-1">Start Date :<br> dasdasd<br>
                                        End Date :<br> dasdasd<br>
                                        Duration :<br> sdasdasd
                                    </td>
                                <td>adda</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
  
        </div>
    </div>
</div> <!-- container-fluid -->