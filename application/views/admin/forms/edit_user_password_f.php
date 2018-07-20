<?php
foreach($user_info as $info)
{
    $id         =$info['id'];
}

?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label">Password</label>
                <div class="col-md-10">
                    <input id="password" type="password" class="form-control" placeholder="password here" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Confirm Password</label>
                <div class="col-md-10">
                    <input id="cpassword" type="password" class="form-control" placeholder="confirm password" value="">
                </div>
            </div>



            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input type="submit" class="btn btn-primary register" value="Edit">
                    <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                </div>
            </div>
        </div>

    </div>
</div>




<script>
    $('.register').click(function(){

        //loading gif
        $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

        var password        =$('#password').val();
        var cpassword       =$('#cpassword').val();

        var form_data =
        {
            password:    password,
            cpassword:   cpassword,
            id:          '<?=$id?>',
            ajax:        'edit_password'
        };

        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
            type: 'POST',
            data: form_data,
            success: function(msg)
            {

                $('.message').html(msg);

            }
        });

        return false;

    });
</script>




