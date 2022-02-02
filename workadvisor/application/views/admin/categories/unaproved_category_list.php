<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> Unaprove Categories 
                    </div><br/>

                    <div class="current_games_section">
                        <table id="team_salary" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Category Name</th>
                                    <th>Category Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($categories['result'])){ $i = 1; foreach ($categories['result'] as $value) { ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $value->name; ?> </td>
                                <td><?php echo (!empty($value->category_status)&& $value->category_status == 1) ? 'Aproved' : 'Unaproved' ; ?> </td>
                                <td>
                                <?php $delUrl = base_url('admin/delete_unaproved_category/'.encoding($value->id));?>
                                <?php $editUrl = base_url('admin/editCategoryForm/'.encoding($value->id));?>
                                <?php $aprove = base_url('admin/aprove_category/'.encoding($value->id));?>
                                <a onclick="return confirm('Do you want to delete')" href="<?php echo $delUrl; ?>" class="btn btn-danger">Delete</a>
                                <a href="<?php echo $editUrl; ?>" class="btn btn-primary">Edit Category</a> 
                                <a href="<?php echo $aprove; ?>" class="btn btn-info">Aprove Category</a> 
                            </td>
                           </tr>
                            <?php $i++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>

