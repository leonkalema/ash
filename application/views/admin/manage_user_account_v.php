<?php
/*
#Author: Cengkuru Micheal
9/23/14
2:51 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<div class="container">
    <div class="row">
        <?=$this->load->view('admin/parts/inner_left_sidebar/profile_manage')?>
        <div class="col-md-9">


            <div class="panel panel-gray">

                <div class="panel-heading">
                    <?php
                    //TODO make this realtime
                    ?>

                    <h4>
                        <div class="pull-right white">
                            <i class="fa fa-home"></i> <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>">Edit Account</a>
                        </div>
                    </h4>
                    <div class="options">

                    </div>
                </div>
                <div class="panel-body">
                    <?=$this->load->view('admin/forms/edit_user_acc_f')?>

                </div>
            </div>


        </div>

    </div>
</div>
 