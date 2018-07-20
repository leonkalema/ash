<?php
foreach($user_info as $info)
{
    $id         =$info['id'];
    $fname      =$info['fname'];
    $lname      =$info['lname'];
    $email      =$info['email'];
    $usertype   =$info['usertype'];
    $tel        =$info['tel'];

}

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
                    <input type="text" id="fname" value="<?=ucfirst($fname)?>" class="form-control" placeholder="first name here">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Last name</label>
                <div class="col-md-10">
                    <input type="text" id="lname" value="<?=ucfirst($lname)?>" class="form-control" placeholder="last name here">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Select</label>
                <div class="col-md-10">
                    <select id="usertype" class="form-control">
                        <option class="text-info" selected="" value="<?=$usertype?>"><?=ucwords(get_usertype_by_type_id($usertype,'title'))?></option>
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
            <div class="form-group">
                <label class="col-md-2 control-label">Email</label>
                <div class="col-md-10">
                    <input type="text" value="<?=$email?>" id="email" class="form-control" placeholder="email here">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Telephone</label>
                <div class="col-md-10">
                    <input type="text" value="0<?=$tel?>" id="tel" class="form-control" placeholder="telephone">
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
            id:          '<?=$id?>',
            ajax:        'edit'
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




