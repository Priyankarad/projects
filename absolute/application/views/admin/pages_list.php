<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Administrator</a></li>
            <li class="active">Pages</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php alert(); ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Pages List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Modify</th>
                        </tr>
                        <?php  
                        $pagesArr = array('about','services','home','download');
                        $count = 0;
                        foreach($pagesArr as $page){
                            $count++; ?>
                            <tr>
                            <td><?php echo $count;?></td>
                            <td><?php echo ucwords($page);?></td>
                            <td>
                                <?php $mid = encoding($count);?>
                                <a href="<?php echo site_url('administrator/editpage/'.$mid);?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a></td>
                        </tr>
                        <?php }
                        ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>