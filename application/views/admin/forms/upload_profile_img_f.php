<?php
/*
#Author: Cengkuru Micheal
9/23/14
2:54 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
foreach($user_info as $row)
{
    $user_id    =$row['id'];
    $slug       =$row['slug'];
    $avatar     =$row['avatar'];
}
?>




<fieldset>
    <?php
    $attributes =
    array
    (
    'class' => 'form-horizontal row-border',
    'name'  =>'fileinfo'
    );
    echo form_open_multipart(current_url(),$attributes);

    //if there are errors
    if(isset($errors))
    {
    ?>
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h3>Oh Snap!</h3>

        <p><?=$errors?></p>

    </div>
    <?php
    }

    if(isset($success))
    {
        ?>
        <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h3>Well Done!</h3>

            <p>Image was successfully uploaded</p>

        </div>
    <?php
    }
    ?>


    <input  type="hidden"  name="user_id" value="<?=$user_id?>" class="form-control" id="user_id" >




    <div class="form-group">
        <label for="ticket-attachment" class="col-sm-3 control-label">Upload image</label>
        <div class="col-md-9">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?=base_url().'uploads/avatars/'.get_thumbnail($avatar)?>"></div>
            <?php
            $data = array
            (
                'name'        => 'userfile',
                'id'          => 'userfile',
                'value'       => set_value('userfile'),
                'maxlength'   => '',
                'size'        => '',
                'style'       => '',
            );

            echo form_upload($data);

            ?>
            <p class="help-block"><em>Valid file type: .jpg, .png</em></p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <input type="submit" class="btn btn-primary " id="upload" name="upload" value="Upload Image" />&nbsp;
            <a class="btn btn-info" href="<?=base_url().$this->uri->segment(1).'/'?>users/profile/<?=$slug?>">Back to profile</a>
        </div>
    </div>
</fieldset>
 