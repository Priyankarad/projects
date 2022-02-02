
<?php if(!empty($MyhistoryRating)){
    if(isset($MyhistoryRating[0]) && $MyhistoryRating[0]=='empty'){
        echo '<div class="alert alert-danger">No reviews found</div>';
    }
    else{  
        $count = 0;
        foreach($MyhistoryRating as $key=>$historyratings){ 
            $count++;

            $i=0; foreach($historyratings as $r){
                $userProfileUrl = site_url('viewdetails/profile/'.encoding($r['retedbyid']));
                ?>   

                <li class="ful_cntant min-pdn">
                    <div class="lin-higthdiv">
                        <div class="row pading-tp F_reviewC">
                            <div class="col-md-1">
                                <div class="profil-mgg">

                                    <a href="<?php  
                                    if($r['anonymous']!=1)
                                    echo $userProfileUrl;
                                    else
                                    echo '#';
                                    ?>">
                                    <img src="<?php echo (!empty($r['profile']) && $r['profile']!='assets/images/default_image.jpg')? $r['profile']:base_url().DEFAULT_IMAGE; ?>" alt="<?php echo $r['givername']; ?>">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="howwas chg chg">
                                <h2><?php 
                                if($r['anonymous']!=1)
                                    echo $r['givername']; 
                                else
                                    echo 'Anonymous user';?></h2>
                                <p><?php echo $r['address']; ?></p>
                                <?php echo isset($r['star_ratings']['starRating'])?preg_replace("/\([^)]+\)/","",$r['star_ratings']['starRating']):'';?>
                            </div>
                        </div>

                        <div class="col-md-9">

                            <!--row start-->
                            <div class="row">

                                <div class="col-md-11">
                                    <div class="combaine-ss">


                                        <div class="questin">
                                            <p><?php
                                            if($r['user_role'] == 'Performer')
                                                echo isset($category_questions_performer[0]['question'])?$category_questions_performer[0]['question']:'';
                                            else
                                                echo isset($category_questions_employer[0]['question'])?$category_questions_employer[0]['question']:''; ?>
                                        </p>
                                    </div> 
                                    <?php  echo preg_replace("/\([^)]+\)/","",$r[0]); ?>
                                </div>
                            </div>
                        </div>
                        <!--row close-->
                        <!--row start-->
                        <div class="row">
                            <div class="col-md-11">
                                <div class="combaine-ss">
                                    <div class="questin">
                                        <p><?php  if($r['user_role'] == 'Performer')
                                        echo isset($category_questions_performer[1]['question'])?$category_questions_performer[1]['question']:'';
                                        else
                                            echo isset($category_questions_employer[1]['question'])?$category_questions_employer[1]['question']:'';  ?>
                                    </p>
                                </div>
                                <?php  echo preg_replace("/\([^)]+\)/","",$r[1]); ?> 
                            </div>

                        </div>
                    </div>
                    <!--row close-->
                    <div class="row">
                        <div class="col-md-11">
                            <div class="combaine-ss">
                                <div class="questin">
                                    <p><?php  if($r['user_role'] == 'Performer')
                                    echo isset($category_questions_performer[2]['question'])?$category_questions_performer[2]['question']:'';
                                    else
                                        echo isset($category_questions_employer[2]['question'])?$category_questions_employer[2]['question']:'';  ?>
                                </p>
                            </div> 
                            <?php  echo preg_replace("/\([^)]+\)/","",$r[2]); ?>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <div class="combaine-ss"> 
                            <div class="questin">
                                <p><?php if($r['user_role'] == 'Performer')
                                echo isset($category_questions_performer[3]['question'])?$category_questions_performer[3]['question']:'';
                                else
                                    echo isset($category_questions_employer[3]['question'])?$category_questions_employer[3]['question']:'';  ?>
                            </p>
                        </div> 
                        <?php  echo preg_replace("/\([^)]+\)/","",$r[3]); ?>
                    </div>

                </div>
            </div>
            <!--row start-->
            <div class="row">
                <div class="col-md-11">
                    <div class="combaine-ss">
                        <div class="questin">
                            <p><?php  if($r['user_role'] == 'Performer')
                            echo isset($category_questions_performer[4]['question'])?$category_questions_performer[4]['question']:'';
                            else
                                echo isset($category_questions_employer[4]['question'])?$category_questions_employer[4]['question']:'';  ?>,
                        </p>
                    </div> 
                    <?php  echo preg_replace("/\([^)]+\)/","",$r[4]); ?>
                </div>
                

<div id="modalDelete<?php echo $r['rate_id']?>" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div id="success"></div>
            <div class="modal-header">        
                <h4 class="modal-title">Are you sure?</h4>  
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this review ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <a href="<?php echo base_url();?>user/deleteReview/<?php echo encoding($user_id);?>/<?php echo encoding(get_current_user_id());?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>  
                <!--comment view-->
                <div class="coment-fd">
                    <p><i class="fa fa-comment" aria-hidden="true"></i> <?php echo $r['message']; ?></p>
                </div>
<?php if(get_current_user_id() && get_current_user_id() == $r['retedbyid']){ ?>
<a href="" class="delete_comments" data-toggle="modal" data-target="#modalDelete<?php echo $r['rate_id']?>"><i class="fa fa fa-trash-o"></i> Review</a>
<?php } ?>
            </div>

        </div>

    </div>
</div>
</li>
<?php $i++; }  }
}
} ?> 

