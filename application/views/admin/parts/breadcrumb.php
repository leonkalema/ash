<?php
if($this->session->userdata('logged_in'))
{
    ?>
    <div class="col-md-4">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="#">Home</a></li>
            <li class="active"><?=ucwords($this->router->fetch_class())?></li>
        </ul>
    </div>
    <?php
}else
{
    ?>
    <div class="col-md-8">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="<?=base_url()?>">Home</a></li>
            <li><a href="<?=base_url()?>current_projects">Current Platforms</a></li>
            <li><a href="http://www.acode-u.org/" target="_blank">Visit ACODE website</a></li>
        </ul>
    </div>
    <?php
	//login & Registration
}

