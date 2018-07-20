
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
                    <?=$this->load->view('admin/parts/inner_left_sidebar/project_menu')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?php
                        echo $pages;
                        //if there are usertypes
                        if($all_subscribers)
                        {
                            ?>
                            <div class="messages">
                                <table class="table-condensed message-table" width="100%" cellpadding="0" cellspacing="0">
                                    <colgroup>
                                        <col class="col-check">
                                        <col class="col-star">
                                        <col class="col-from">
                                        <col class="col-title">
                                        <col class="col-attachment">
                                        <col class="col-timestamp">
                                    </colgroup>
                                    <tbody>
                                    <?php
                                    foreach($all_subscribers_paginated as $user)
                                    {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="simple-checkbox">
                                                    <input type="checkbox" id="checkbox10"><label for="checkbox10">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-star-o"></i></td>
                                            <!-- user types-->
                                            <td><span class="from"><a href="#"><?=ucwords(get_user_info_by_id($user['user_id'],'usertype'))?></a> </span></td>

                                            <td><span class="from"><img class="img-circle pull-left" width="32px" height="32px" src="<?=base_url()?>uploads/avatars/<?=get_thumbnail(get_user_info_by_id($user['user_id'],'avatar'))?>"> <a  style="padding: 10px;" href="<?=base_url().$this->uri->segment(1).'/users'?>/profile/<?=get_user_info_by_id($user['user_id'],'slug')?>"><?=ucwords(get_user_info_by_id($user['user_id'],'firstname')==''?'(256) '.get_user_info_by_id($user['user_id'],'tel'):get_user_info_by_id($user['user_id'],'fullname'))?></a></span></td>
                                            <td>&nbsp;</td>


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
                                <h3>Notice!</h3>

                                <p>No subscribers to display</p>

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

