<div class="main-content">
    <!-- INBOX -->
    <div class="inbox">

        <div class="top">
            <div class="bottom">
                <div class="row">
                    <!-- inbox left menu -->
                    <?=$this->load->view('admin/parts/inner_left_sidebar/parish_manage')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?=$this->load->view('admin/forms/add_parish_f')?>
                    </div>
                    <!-- end right main content, the messages -->
                </div>
            </div>

        </div>
        <!-- END INBOX -->

    </div><!-- /main-content -->
