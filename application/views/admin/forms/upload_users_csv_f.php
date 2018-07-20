<?php
/*
#Author: Cengkuru Micheal
9/23/14
2:54 PM
*/
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
            <h3>Notice !</h3>

            <p><?=$errors?></p>

        </div>
    <?php
    }

    if(isset($success))
    {
        ?>
        <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h3>Notice !</h3>

            <p>Content was successfully imported</p>

        </div>
    <?php
    }
    ?>



    <div class="form-group">
        <label for="ticket-attachment" class="col-sm-3 control-label">Import file</label>
        <div class="col-md-9">

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
            <p class="help-block"><em>Valid file type: .csv, .xls, .xlsx</em></p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <input type="submit" class="btn btn-primary " id="upload" name="upload" value="Import" />
        </div>
    </div>
</fieldset>
 