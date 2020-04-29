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
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                <form role="form" class="ajaxForm" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                        <input type="hidden" id="csrftoken" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <div class="form-group">
                            <label >Nama</label>
                            <input type="text" class="name_tax form-control" name="name" value="<?php echo $name;?>">
                            <small id="emailHelp" class="form-text text-muted">Nama kategori yang akan muncul di situs.</small>
                        </div>
                        <div class="form-group">
                            <label >Kategori Induk</label>
                            <select class="form-control" name="parent">
                            <option value="0"></option>
                            <?php foreach ($data_term as $category): ?>
                            <?php if($category->term_id != '1' && $category->term_id != $term_id){ ?>
                            <option value="<?php echo $category->term_id;?>" <?php if($parent == $category->term_id){ echo 'selected'; }?>><?php echo $category->name;?></option>
                            <?php } ?>
                            <?php endforeach ?>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Kategori Induk dapat memiliki hierarki. Misal Musik dan di bawahnya ada kategori Pop, Jazz. Opsional.</small>
                        </div>
                        <div class="form-group">
                            <label for="namakategori">Deskripsi</label>
                            <textarea class="form-control" name="description"><?php echo $description;?></textarea>
                            <small id="emailHelp" class="form-text text-muted">Keterangan Kategori. Opsional</small>
                        </div>
                        <div class="form-group float-right">
                        
                        <?php if($cancel): ?>
                            <a href="<?php echo $cancel; ?>"
                                class="btn btn-danger mlinks">Cancel</a>
                        <?php endif ?>
                        <button type="submit" class="btn btn-primary"><?php echo ($cancel ? 'Update' : 'Save');?></button>
                        </div>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-xl-8">
            <div class="card <?php if($cancel): echo 'box-disable'; endif ?>">
                <div class="card-body">
                <div class="table-responsive show-table">
                    <table id="datatable" class="table table-hover">
                        <thead>
                        <tr>
                        <th width="200px">Category Name</th>
                        <th>Description</th>
                        <th>Slug</th>
                        <th width="35px">Count</th>
                        </tr>
                        </thead>
                        <tbody class="body-row">
                        <?php $no = 1; foreach ($data_term as $category){ ?>
                                <tr class="row-cat" id="<?php echo $no;?>">
                                    <td>
                                    <strong><?php echo $category->name;?></strong>
                                    <div class="row-action" id="<?php echo 'action'.$no;?>">
                                        <span><a class="mlinks" href="<?php echo site_url('webadmin/posts/category/edit/'.$type.'/'.$category->term_id) ?>">Edit</a></span>
                                        <?php if($category->term_id != '1'){ ?>
                                        <span><a href="javascript:void(0)" class="del mlink" term_url="webadmin/posts/category/delete" term_type="articles" term_id="<?php echo $category->term_id;?>">Delete</a></span>
                                        <?php } ?>
                                        <span><a href="<?php echo site_url($type.'/category/'.$category->slug) ?>"  target="_blank">View</a></span>
                                    </div>
                                    </td>
                                    <td>
                                    <?php if($category->description == ''){ echo '—'; } else { echo $category->description; }?>
                                    </td>
                                    <td>
                                    <?php echo $category->slug;  ?>
                                    </td>
                                    <td>
                                    <a class="mlink" href="<?php echo site_url('webadmin/post?type='.$type.'&filter='.$category->slug) ?>" ><?php echo $category->count;  ?></a>
                                    
                                    </td>
                                </tr>

                                <?php 
                                $data_term_parent = $this->Terms_m->get_terms('category-'.$type, $category->term_id)->result();
                                        foreach($data_term_parent as $category_parent) { ?>
                                <tr  class="row-cat" id="<?php echo $no;?>">
                                    <td>
                                    <strong><?php echo '— '.$category_parent->name; ?></strong>
                                    <div class="row-action" id="<?php echo 'action'.$no;?>">
                                        <span><a class="mlinks" href="<?php echo site_url('webadmin/posts/category/edit/'.$type.'/'.$category->term_id) ?>">Edit</a></span>
                                        <?php if($category_parent->term_id != '1'){ ?>
                                            <span><a href="javascript:void(0)" class="del mlink" term_url="webadmin/posts/category/delete" term_type="articles" term_id="<?php echo $category_parent->term_id;?>">Delete</a></span>
                                        <?php } ?>
                                        <span><a href="<?php echo site_url($type.'/category/'.$category_parent->slug) ?>"  target="_blank">View</a></span>
                                    </div>
                                    </td>
                                    <td>
                                    <?php if($category_parent->description == ''){ echo '—'; } else { echo $category_parent->description; }?>
                                    </td>
                                    <td>
                                    <?php echo $category_parent->slug;  ?>
                                    </td>
                                    <td>
                                    <a class="mlink" href="<?php echo site_url('webadmin/post?type='.$type.'&filter='.$category_parent->slug) ?>" ><?php echo $category_parent->count;  ?></a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php $no++; } ?>

                        </tbody>
                    </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
</div> <!-- container-fluid -->