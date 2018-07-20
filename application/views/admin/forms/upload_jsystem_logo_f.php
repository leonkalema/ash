<?php 
/*
#Author: Cengkuru Micheal
9/25/14
10:21 AM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//print_array($jsystem_info);
foreach($jsystem_info as $info)
{
    $id=$info['id'];
}
?>
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
<div class="form-group">
    <label class="col-sm-3 control-label">Image Upload</label>
    <div class="col-sm-9">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
            <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
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
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
            </div>
        </div>
    </div>
</div>
<input  type="hidden"  name="id" value="<?=$id?>" class="form-control">

<input type="submit" class="btn btn-primary " id="upload" name="upload" value="Upload Image" />


</form>
 