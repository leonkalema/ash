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
                        <div class="messages">
                            <table class="table-condensed message-table" width="100%" cellpadding="0" cellspacing="0">
								<tr>
            						<td>PROJECT NAME</td>
            						<td>RECIEVED MESSAGES</td>
            						<td>SENT MESSAGES</td>
        						</tr>
                                <tr>
                                <tbody>
                                <?php
        						foreach($all_projects_paginated as $projects)
        						{
            					?>
            					<tr>
                					<td><span class="from"><?=ucwords($projects['title'])?></span></td>
                					<td>Valid (<?=count(get_recieved_messages_by_shotcode($projects['shortcode']))?>)<a class="col-md-offset-1" href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/edit/<?=$projects['slug']?>"  ><i class="fa fa-print text-info"></i></a></td>
                					<td>Integration <a class="col-md-offset-1" href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/edit/<?=$projects['slug']?>"  ><i class="fa fa-print text-info"></i></a></td>
            					</tr>
        						<?php
        						}
        						?>
                                </tbody>
                            </table>
                        </div>
                </div>
                <!-- end right main content, the messages -->
            </div>
        </div>

    </div>
    <!-- END INBOX -->

</div><!-- /main-content -->
