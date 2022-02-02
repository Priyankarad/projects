<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> <?php echo isset($pageData->name)?$pageData->name:'';?>
                    </div><br/>
                    <form action="<?php echo base_url()?>settings/save_page_data" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo isset($pageData->id)?$pageData->id:'';?>">

                        <div>
                            <h5>Image</h5>
                            <input type='file' id="upload" name="image" accept="image/*" onChange="readURL(this);"/>
                            <img id="img" src="<?php echo (isset($pageData->image) && !empty($pageData->image))?$pageData->image:base_url().'assets/images/default_image.jpg';?>" alt="your image" height="20%" width="20%">
                            <br/><br/>
                        </div>

                        <div>
                            <h5>Heading 1</h5>
                            <input type="text" class="form-control" name="heading_1" value="<?php echo isset($pageData->heading_1)?$pageData->heading_1:'';?>"><br/><br/>
                        </div>

                        <div>
                            <h5>Content 1</h5>
                            <textarea name="content_1" id="content_1" style="width: 100%;">
                                <?php echo isset($pageData->content_1)?$pageData->content_1:'';?>
                            </textarea><br/><br/>
                        </div>

                        <div>
                            <h5>Heading 2</h5>
                            <input type="text" class="form-control" name="heading_2" value="<?php echo isset($pageData->heading_2)?$pageData->heading_2:'';?>"><br/><br/>
                        </div>

                        <div>
                            <h5>Content 2</h5>
                            <textarea name="content_2" id="content_2" style="width: 100%;">
                                <?php echo isset($pageData->content_2)?$pageData->content_2:'';?>
                            </textarea><br/><br/>
                        </div>

                        <div>
                            <h5>Content 3</h5>
                            <textarea name="content_3" id="content_3" style="width: 100%;">
                                <?php echo isset($pageData->content_3)?$pageData->content_3:'';?>
                            </textarea><br/><br/>
                        </div>

                        <div>
                            <h5>Content 4</h5>
                            <textarea name="content_4" id="content_4" style="width: 100%;" >
                                <?php echo isset($pageData->content_4)?$pageData->content_4:'';?>
                            </textarea><br/><br/>
                        </div>

                        <div>
                            <h5>Heading 3</h5>
                            <input type="text" class="form-control" name="heading_3" value="<?php echo isset($pageData->heading_3)?$pageData->heading_3:'';?>"><br/><br/>
                        </div>

                        <div>
                            <h5>Content 5</h5>
                            <textarea name="content_5" id="content_5" style="width: 100%;">
                                <?php echo isset($pageData->content_5)?$pageData->content_5:'';?>
                            </textarea><br/><br/>
                        </div>

                        <div>
                            <h5>Content 6</h5>
                            <textarea name="content_6" id="content_6" style="width: 100%;">
                                <?php echo isset($pageData->content_6)?$pageData->content_6:'';?>
                            </textarea><br/><br/>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Save">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</section>

