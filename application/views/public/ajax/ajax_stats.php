<li>
    <h5>Visitors<span class="stat-value stat-color-orange"><i class="fa fa-plus-circle"></i> <?=get_count_visitiors()?></span></h5>

</li>
<?php
if(in_array(get_user_info_by_id($this->session->userdata('user_id'),'usertype_id'),$this->config->item('admins')))
{

	if($this->session->userdata('logged_in_usertype')==1)
    {
    	foreach(get_active_usertypes() as $usertype)
    	{
            $system_usertypes=array('1','2','4');
            if(in_array($usertype['id'],$system_usertypes))
            {
                ?>
                    <li>
                        <h5><?=strtoupper($usertype['usertype'])?><span class="stat-value stat-color-orange"><i class="fa fa-plus-circle"></i> <?=count(get_users_by_usertype($usertype['id']))?></span></h5>
                    </li>
                <?php
            }else{ echo ''; }
    	}
    }
}

?>