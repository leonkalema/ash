<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/21/14
 * Time: 1:27 PM
 * registration form
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
                <div class="form-group">
                    <label class="col-md-2 control-label">Select</label>
                    <div class="col-md-10">
                        <select id="usertype" class="form-control">
                            <option disabled selected>Choose user group</option>
                            <?php
                            $usertypes=get_active_usertypes();
                            foreach($usertypes as $type)
                            {
                                ?>
                                <option  value="<?=$type['id']?>"><?=ucwords($type['usertype'])?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="project">

                </div>
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
                        <input type="submit" id="register" class="btn btn-primary register" value="Register">
                        <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>

    $(document).ready(function()
    {
        $(".project").hide();
        $("#usertype").change(function ()
        {
            //if chosen type is project managers
            if ($("#usertype").val() == 2)
            {
                $(".project").show('slow');
                $(".project").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

                var form_data =
                {
                    usertype: $("#usertype").val() ,
                    ajax: 'get_projects'
                };

                $.ajax({
                    url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))?>",
                    type: 'POST',
                    data: form_data,
                    success: function (msg)
                    {
                        $('.project').html(msg);

                    }
                });
            }
            else
            {
                //hide
                $(".project").hide();
            }
        });

        $('#register').click(function()
        {
            var fname    =$('#fname').val();
            var lname    =$('#lname').val();
            var usertype =$('#usertype').val();
            var email    =$('#email').val();
            var tel      =$('#tel').val();
            var password =$('#password').val();
            var cpassword   =$('#cpassword').val();
            var projectid  = $('#project_id').val();

            if(usertype == 2)
            {
                var form_data =
                {
                    fname: fname,
                    lname: lname,
                    usertype: usertype,
                    projectid: projectid,
                    email: email,
                    tel:   tel,
                    password: password,
                    cpassword: cpassword,
                    ajax:   'register'
                };

            }else
            {
                var form_data =
                {
                    fname: fname,
                    lname: lname,
                    usertype: usertype,
                    email: email,
                    tel:   tel,
                    password: password,
                    cpassword: cpassword,
                    ajax:   'register'
                };

            }

            $.ajax({
                url: "<?php echo site_url('admin/users/add') ?>",
                type: 'POST',
                data: form_data,
                success: function(msg) {
                $('.message').html(msg);
                }
            });
            return false;

        });

    });
</script>