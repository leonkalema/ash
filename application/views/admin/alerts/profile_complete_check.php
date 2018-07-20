<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/10/2014
 * Time: 12:48 PM
 */
//views not for super users and admins
if(!in_array(get_user_info_by_id($this->session->userdata('user_id'),'usertype_id'),$this->config->item('admins')))
{
    if(get_user_additional_info($this->session->userdata('user_id'),'district'))
    {
        ?>
        <div class="alert alert-dismissable alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Welcome <img class="img-circle" width="32px" height="32px" src="<?=base_url()?>uploads/avatars/<?=$this->session->userdata('logged_in_user_avater')?>" /><b>
                <span class="name"><?=ucwords(get_user_info_by_id($this->session->userdata('user_id'),'fullname'))?></span></b>
            <p>
                Provide your <a href="<?=base_url().'admin/users/edit_location/',get_user_info_by_id($this->session->userdata('user_id'),'slug')?>">district information</a>  so you can get district specific messages
            </p>

        </div>
    <?php
    }

}

