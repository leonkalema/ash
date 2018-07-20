
<div class="main-content">

    <div class="inbox">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <!-- search box -->
                <?=$this->load->view('admin/forms/search_box_f')?>
                <!-- end search box -->
            </div>
        </div>
        <div class="top">
            <div class="bottom">
                <div class="row">
                    <!-- inbox left menu -->
                    <?=$this->load->view('admin/parts/inner_left_sidebar/message_manage')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?php
                        echo $pages;
                        //if there are usertypes
                        if($all_projects)
                        {
                            ?>
                            <div class="messages">
                                <table class="table-condensed message-table" width="100%" cellpadding="0" cellspacing="0">
                                    <!-- <colgroup>
                                        <col class="col-from">
                                        <col class="col-from">
                                        <col class="col-title">
                                        <col class="col-timestamp"> -->
                                    </colgroup>
                                    <tr>
                                        <td>PROJECT NAME</td>
                                        <td>SHORTCODE</td>

                                    </tr>
                                    <tbody>
                                    <?php
                                    foreach($all_projects_paginated as $projects)
                                    {
                                        ?>
                                        <tr>
                                            <td><span class="from"><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$projects['slug']?>"><?=ucwords($projects['title'])?></a></span></td>
                                            <td><?=$projects['shortcode']?></td>

                                        </tr>
                                    <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        <?php
                        }
                        else
                        {
                            //if there are no user types
                            ?>
                            <div class="alert alert-dismissable alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Heads up!</h3>

                                <p>No values to display</p>

                            </div>
                        <?php
                        }
                        ?>

                    </div>
                    <!-- end right main content, the messages -->
                </div>
            </div>

        </div>


    </div><!-- /main-content -->

