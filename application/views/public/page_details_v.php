<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 9:15 PM
 */
//extract page id
foreach($page_info as $info)
{
    $id=$info['id'];
    $content=$info['content'];
}
?>
<div class="col-lg-9">
    <div class="widget ">
        <div class="widget-header">
            <h3><?=remove_dashes(ucwords($this->uri->segment(2)))?></h3>
        </div>
        <div class="widget-content">
            <?=html_entity_decode($content)?><div class="fb-like" data-href="https://www.facebook.com/pages/Advocates-Coalition-for-Development-and-Environment-ACODE/220046328033059" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        </div>
        <div class="widget-footer">

        </div>
    </div>
</div>
