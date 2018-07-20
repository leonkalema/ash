<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/9/2014
 * Time: 9:34 AM
 */
?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label">First name</label>
                <div class="col-md-10">
                    <input type="text" id="fname" class="form-control" placeholder="first name here">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Last name</label>
                <div class="col-md-10">
                    <input type="text" id="lname" class="form-control" placeholder="last name here">
                </div>
            </div>


<!--            4 is for regular site member-->
            <input type="hidden" id="usertype" value="4" class="form-control">

            <div class="form-group">
                <label class="col-md-2 control-label">Email</label>
                <div class="col-md-10">
                    <input type="text" id="email" class="form-control" placeholder="email here">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Phone number</label>
                <div class="col-md-10">
                    <input type="text" id="tel" maxlength="10" class="form-control" placeholder="telephone here">
                </div>
            </div>

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
                    <input type="submit" class="btn btn-primary register" value="Register">
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


        var fname           =$('#fname').val();
        var lname           =$('#lname').val();
        var email           =$('#email').val();
        var usertype        =$('#usertype').val();
        var password        =$('#password').val();
        var cpassword       =$('#cpassword').val();
        var tel             =$('#tel').val();


        var form_data =
        {
            fname :      fname,
            lname :      lname,
            email :      email,
            usertype:    usertype,
            password:    password,
            cpassword:   cpassword,
            tel:         tel,
            ajax:        'register'
        };

        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1))?>",
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