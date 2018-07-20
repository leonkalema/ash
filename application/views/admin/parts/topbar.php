<?php
//print_array($this->session->all_userdata());
?>
<!-- TOP BAR -->
<div class="top-bar">
<div class="container">
<div class="row">
<!-- logo -->
<div class="col-md-2 logo">
    <a href="<?=base_url()?>"><label style="color:#ffffff">
    <img src="<?=base_url()?>assets/img/acode.png" alt="ACODE" style="height:25px" />
    </label></a>
    <h1 class="sr-only"><?=$pagetitle?></h1>
</div>
<!-- end logo -->
<div class="col-md-10">
<div class="row">
<div class="col-md-3">
    <!-- search box -->
    <?php //=$this->load->view('admin/forms/top_search_f')?>
    <!-- end search box -->
</div>
<div class="col-md-9">
<div class="top-bar-right">
<div class="notifications">
    <ul>
        <?php
        //if user is logged in
        //if user is logged in
        if($this->session->userdata('logged_in')==TRUE&&!$this->uri->segment(1))
        {
            ?>

            <li class="notification-item"><a style="color: #fff;" target="_blank" href="<?= base_url() ?>admin/dashboard">Dashboard</a>
            </li>
        <?php
        }
        else
        {
            if($this->session->userdata('logged_in')==TRUE)
            {
                ?>
                <li class="notification-item"><a style="color: #fff;" target="_blank" href="<?= base_url() ?>">&nbsp;</a>
                </li>
            <?php
            }

            ?>

        <?php
        }
        ?>


    </ul>
</div>

<!-- logged user and the menu -->
<div class="logged-user">
    <div class="btn-group">
        <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
            <?php
            //if user is logged in
            //if user is logged in
            if($this->session->userdata('logged_in')==TRUE)
            {
                ?>
                <img class="img-circle" width="32px" height="32px" src="<?=base_url()?>uploads/avatars/<?=$this->session->userdata('logged_in_user_avater')?>" />
                <span class="name"><?=ucwords(get_user_info_by_id($this->session->userdata('user_id'),'fullname'))?></span> <span class="caret"></span>
            <?php

            }
            else
            {
                ?>
                <img class="img-circle" width="32px" height="32px" src="<?=base_url()?>uploads/avatars/avatar.jpg?>" />
                <label>You are here as a Guest. Register or Login Here. </label> <span class="caret"></span>
            <?php

            }

            ?>

        </a>
        <ul class="dropdown-menu" role="menu">

            <?php
            //if user is logged in
            if($this->session->userdata('logged_in')==TRUE)
            {
                ?>
                <li>
                    <a href="<?=base_url().'admin/'?>users/profile/<?=get_user_info_by_id($this->session->userdata('user_id'),'slug')?>">
                        <i class="fa fa-user"></i>
                        <span class="text">Profile</span>
                    </a>
                </li>

                <li>
                    <a href="<?=base_url().'admin/login/logout'?>">
                        <i class="fa fa-power-off"></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
            <?php
            }
            else
            {
                //when not logged in
                ?>
                <li>
                    <a href="#">
                        Hi Guest!
                    </a>

                </li>

                <li>
                    <a href="<?=base_url()?>/register">
                        <i class="fa fa-user"></i>
                        <span class="text">Register</span>
                    </a>
                </li>

                <li>
                    <a href="<?=base_url().'admin/login'?>">
                        <i class="fa fa-sign-in"></i>
                        <span class="text">Login</span>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>
<!-- end logged user and the menu -->
</div><!-- /top-bar-right -->
</div>
</div><!-- /row -->
</div>
</div><!-- /row -->
</div><!-- /container -->
</div><!-- /top -->