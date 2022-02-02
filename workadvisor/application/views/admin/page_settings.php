<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> Pages List
                        
                    </div><br/>
                    <div class="current_games_section">
                      <?php 
                        if($this->session->flashdata('content_update')){
                          echo $this->session->flashdata('content_update');
                        }
                      ?>
                        <table id="team_salary" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Page Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                              if(!empty($pageData['result'])){
                                $count = 0;
                                foreach ($pageData['result'] as $page) {
                                  $count++; ?>
                                  <tr>
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $page->name;?></td>
                                    <td><a class="btn btn-primary" href="<?php base_url()?>page_contents/<?php echo encoding($page->id);?>">Edit</a></td>
                                  </tr>
                               <?php }
                              }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>

