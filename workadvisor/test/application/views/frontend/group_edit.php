
                <input type="text" class="form-control" name="group_name" placeholder="Group Name" id="group_name" required="" value="<?php echo isset($groupMembers->name)?$groupMembers->name:''; ?>">

                <select class="form-control contacts"   multiple="multiple" style="width: 466px;" required="">
                    <?php if(!empty($contactsData)){
                        foreach($contactsData as $row){ ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php }
                    } ?>
                </select>
                <input type="file" name="group_profile" class="form-control">
               <!--  <img src="<?php echo isset($groupMembers->group_icon)?$groupMembers->group_icon:'';?>"> -->
           