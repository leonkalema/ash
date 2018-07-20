
<div class="main-content">
    <!-- INBOX -->
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
                        if($all_messages)
                        {
                            echo $pages;
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
                                        <td>TELEPHONE</td>
                                        <td>PROJECT</td>
                                        <td>USER</td>


                                    </tr>
                                    <tbody>
                                    <?php
                                    foreach($all_messages_paginated as $message)
                                    {
                                        ?>
                                        <tr>
                                            <td><span class="from">0<?=$message['tel']?></span></td>
                                            <td><?=get_project_by_type_id($message['project'],'shortcode')==''?'Universal':get_project_id_by_shortcode(get_project_by_type_id($message['project'],'shortcode'),'title')?></td>
                                            <td><span class="from"><?=get_user_info_by_id($message['user_id'],'firstname')==''?'<a href="'.base_url().'admin/users/profile/'.get_user_info_by_id($message['user_id'],'slug').'">Edit details</a>':get_user_info_by_id($message['user_id'],'firstname')?></span></td>


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
                                <h3>Notice !</h3>

                                <p>No sent messages to display</p>

                            </div>
                        <?php
                        }
                        ?>

                    </div>
                    <!-- end right main content, the messages -->
                </div>
            </div>

        </div>
        <!-- END INBOX -->

    </div><!-- /main-content -->