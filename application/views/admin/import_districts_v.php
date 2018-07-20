<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/5/2014
 * Time: 10:05 PM
 */
?>
<div class="main-content">
    <!-- INBOX -->
    <div class="inbox">

        <div class="top">
            <div class="bottom">
                <div class="row">
                    <!-- inbox left menu -->
                    <?=$this->load->view('admin/parts/inner_left_sidebar/district_manage')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?=$this->load->view('admin/forms/upload_districts_csv_f')?>
                    </div>
                    <!-- end right main content, the messages -->
                </div>
            </div>

        </div>
        <!-- END INBOX -->

    </div><!-- /main-content -->