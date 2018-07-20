<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/2/14
 * Time: 9:59 AM
 */
foreach($user_info as $info)
{
    $slug=$info['avatar'];//get the user image
    $district_id = $info['district'];
    $subcounty_id = $info['subcounty'];
    $parish_id = $info['parish'];
}
?>

<div class="main-content">
<!-- NAV TABS -->
<ul class="nav nav-tabs">

</ul>
<!-- END NAV TABS -->

<div class="tab-content profile-page">
<!-- PROFILE TAB CONTENT -->
<div class="tab-pane profile active" id="profile-tab">
    <div class="row">
        <div class="col-md-3">
            <div class="user-info-left">
                <img src="<?=base_url()?>uploads/avatars/<?=get_thumbnail($slug)?>" alt="Profile Picture">
                <h2><?=ucwords(get_user_info_by_id($passed_id,'fullname'))?> <a href="<?=base_url().$this->uri->segment(1).'/'?>users/edit_image/<?=get_user_info_by_id($passed_id,'slug')?>"><i class="fa fa-edit"></i></a> </h2>
            </div>
        </div>
        <div class="col-md-9">
            <div class="user-info-right">
                <div class="basic-info">
                    <h3><i class="fa fa-square"></i> Basic Information</h3>
                    <p class="data-row">
                        <span class="data-name">Email</span>
                        <span class="data-value"><?=get_user_info_by_id($passed_id,'email')?></span>
                    </p>
                    <p class="data-row">
                        <span class="data-name">Phone number</span>
                        <span class="data-value">0<?=get_user_info_by_id($passed_id,'tel')?></span>
                    </p>

                    <p class="data-row">
                        <span class="data-name">Last Login</span>
                        <span class="data-value"><?=custom_date_format("F ,jS Y, g:i a",get_user_info_by_id($passed_id,'lastlogin'))?></span>
                    </p>
                    <p class="data-row">
                        <span class="data-name">Date Joined</span>
                        <span class="data-value"><?=custom_date_format("F ,jS Y, g:i a",get_user_info_by_id($passed_id,'dateadded'))?></span>
                    </p>

                    <p class="data-row">
                        <span class="data-name">Update</span>
                        <span class="data-value"><a href="<?=base_url().$this->uri->segment(1).'/'?>users/edit/<?=get_user_info_by_id($passed_id,'slug')?>"><i class="fa fa-edit"></i></a> </span>
                    </p>
                </div>
                <div class="contact_info">
                    <h3><i class="fa fa-square"></i> Account Information</h3>
                    <p class="data-row">
                        <span class="data-name">User Password</span>
                        <span class="data-value">xxxxxxxxxxxxx</span>
                    </p>
                    <p class="data-row">
                        <span class="data-name">Update</span>
                        <span class="data-value"><a href="<?=base_url().$this->uri->segment(1).'/'?>users/edit_password/<?=get_user_info_by_id($passed_id,'slug')?>"><i class="fa fa-edit"></i></a> </span>
                    </p>
                </div>
                <div class="contact_info">
                    <h3><i class="fa fa-square"></i> Location Information</h3>
                    <p class="data-row">
                        <span class="data-name">District</span>
                        <span class="data-value"><?=ucwords(get_district_by_id($district_id,'title'))?></span>
                    </p>
                    <p class="data-row">
                        <span class="data-name">Sub county </span>
                        <span class="data-value"><?=ucwords(get_sub_county_by_id($subcounty_id,'title'))?></span>
                    </p>
                    <p class="data-row">
                        <span class="data-name">Parish</span>
                        <span class="data-value"><?=ucwords(get_parish_by_id($parish_id,'title'))?></span>
                    </p>

                    <p class="data-row">
                        <span class="data-name">Update</span>
                        <span class="data-value"><a href="<?=base_url().$this->uri->segment(1).'/'?>users/edit_location/<?=get_user_info_by_id($passed_id,'slug')?>"><i class="fa fa-edit"></i></a> </span>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END PROFILE TAB CONTENT -->

</div>

</div>





