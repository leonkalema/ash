<?php 
/*
#Author: Cengkuru Micheal
9/22/14
10:40 AM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <h3 class="sr-only">Manage <?=$this->uri->segment(2)?></h3>
    <ul class="list-unstyled left-menu">
        <?php
        if($this->session->userdata('logged_in_usertype')==1)
        {
            //when not on the users page
            if(last_segment()!='page')
            {
                ?>
                <!--remember to take note of data action-->
                <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/page'?>"><i class="fa fa-users"></i> All users<span class="badge pull-right"><?=count(get_active_users())?></span></a></li>

            <?php
            }
            ?>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/add"><i class="fa fa-user"></i> Register user</a></li>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/import"><i class="fa fa-file"></i> Import from Excel</a></li>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/unsubscribers"><i class="fa fa-users"></i> Unsubscribed numbers <span class="badge pull-right"><?=count(get_deactivated_users())?></span></a></li>

            <?php
            //display in certain instances
            $allowed_instances=array('edit','edit_image','edit_location');

            //if the instance is in array display profile link
            if(in_array($this->uri->segment(3),$allowed_instances))
            {
                ?>
                <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/profile/<?=$this->uri->segment(4)?>"><i class="fa fa-user"></i> Back to Profile</a></li>
            <?php
            }
            ?>

            <h6>Filter by user types</h6>
            <?php
            $usertype=get_active_usertypes();

            //print_array($usertype);
            foreach($usertype as $type)
            {
                //do not show for current
                if($type['slug']!=$this->uri->segment(4))
                {
                    ?>
                    <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/usertype/'.$type['slug']?>"><i class="fa fa-user"></i> <?=ucwords($type['usertype'])?> <span class="badge pull-right"><?=count(get_users_by_usertype($type['id']))?></span></a></li>
            <?php
                }
            }

        }

        ?>
    </ul>
</div>