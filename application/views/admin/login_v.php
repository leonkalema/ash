<?php
/*
 * login page view
 * */
?>
<div class="inner-page">

    <div class="logo"><a href="index.html"><img src="<?=base_url()?>assets/img/acode.png" alt="" /></a></div>
<!--    <button type="button" class="btn btn-login-facebook"><span>Login via Facebook</span></button>-->

<!--    <div class="separator"><span>OR</span></div>-->

    <div class="login-box center-block">
        <?php
            //    <!--//load the login form-->
            $this->load->view('admin/forms/login_f');
        ?>



        <div class="links">
<!--            <p><a href="#">Forgot Username or Password?</a></p>-->

            <p><a href="<?=base_url()?>register">Create New Account</a> | <a href="<?=base_url()?>"> Go Back Home</a> </p>
        </div>
    </div>




</div>


