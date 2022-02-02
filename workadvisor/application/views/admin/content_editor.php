<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> <?php echo isset($pageData->name)?$pageData->name:'';?>
                    </div><br/>
                    <form action="<?php echo base_url()?>settings/save_page_data" method="post">
                      <input type="hidden" name="id" value="<?php echo isset($pageData->id)?$pageData->id:'';?>">
                      <textarea name="content_1" style="width: 100%;" >
                        <?php echo isset($pageData->content_1)?$pageData->content_1:'';?>
                      </textarea><br/><br/>
                      <input type="submit" class="btn btn-primary" value="Save">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</section>

