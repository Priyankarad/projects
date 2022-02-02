<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> Users List 
                        
                    </div><br/>
                    <div class="current_games_section">
                        <table id="team_salary" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Employer Name</th>
                                    <th>Contact Number</th>
                                    <th>Mail-Id</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($users['result'])){ $i = 1; foreach ($users['result'] as $value) { ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $value->firstname.' '.$value->lastname; ?> </td>
                                <td><?php echo $value->phone; ?> </td>
                                <td><?php echo $value->email; ?> </td>
                                <td>
                                <?php $delUrl = base_url('admin/delete_users/'.encoding($value->id));?>
                                <a onclick="return confirm('Do you want to delete')" href="<?php echo $delUrl; ?>" class="btn btn-danger">Delete</a> 
                            <a class="btn btn-primary" href="<?php echo base_url().'admin/edit_user/'.encoding($value->id).'/employer'; ?>" class="btn btn-danger">Edit</a>
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

