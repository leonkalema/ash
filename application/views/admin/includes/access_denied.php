<?php 
/*
#Author: Cengkuru Micheal
9/13/14
10:55 AM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="alert alert-dismissable alert-danger ">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h3> <i class="fa fa-warning"></i> Access Denied!</h3>

            <p>You do not have Clearence to view this page</p>
            <br>

            <a href="<?=base_url().$this->uri->segment(1)?>" class="btn btn-danger pulse" id="pulse">Get me out of here</a>
        </div>

    </div>
</div>
<script>
    $(function () {
        $(".pulse").pulsate({reach:20});
    });
</script>

 