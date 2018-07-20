<div class="main-content">
<!-- INBOX -->
<div class="inbox">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-2">
            <!-- search box -->
            <?=$this->load->view('admin/forms/search_box_f', array('search_box_id'=>'search-feedback-box'))?>
            <!-- end search box -->
        </div>
    </div>
    <div class="top">
        <div class="bottom">
            <div class="row">
                <!-- inbox left menu -->
                <?=$this->load->view('admin/parts/inner_left_sidebar/feedback_menu')?>
                <!-- end inbox left menu -->

                <!-- right main content, the messages -->
                <div class="col-xs-12 col-sm-9 col-lg-10">
                    <?php
                    //if there are usertypes
                    if(!empty($all_messages))
                    {
                        ?>
                        <div class="messages">
                            <table class="table-condensed message-table" width="100%" cellpadding="0" cellspacing="0">
                            	<colgroup>
								<col class="col-from">
								<col class="col-title">
							</colgroup>
                                <tbody>
                                <?php
                                foreach($all_messages_paginated as $messages)
                                {
                                    ?>
                                    <tr>
										<td><span class="from"><?=$messages['from']?></span></td>
										<td><span class="message-label label2">New Message</span> 
										<span class="preview">- <?=$messages['msg']?></span></td>
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

                            <p>No feedback to display</p>

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
