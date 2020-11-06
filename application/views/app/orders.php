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
        <div class="card">
                    <div class="card-body">
                <div class="table-responsive show-table">
                    <table id="datatable-order" class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Download</th>
                            <th>Tools</th>
                        </tr>
                        </thead>
                        <tbody>
                         
                        </tbody>
                    </table>
                    </div>
                    </div>
                    </div>
        </div>
    </div>
</div> <!-- container-fluid -->