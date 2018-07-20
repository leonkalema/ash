
<div class="main-content">

    <div class="inbox">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <!-- search box -->
                <?php #$this->load->view('admin/forms/search_box_f')?>
                <!-- end search box -->
            </div>
        </div>
        <div class="top">
            <div class="bottom">
                <div class="row">

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <div class="widget">
                            <div class="widget-header"><h3><i class="fa fa-magic"></i> Reports</h3></div>

                                <div class="widget-content">

                                    <?php
                                    //print_array($this->session->all_userdata());
                                    if($this->session->userdata('logged_in_usertype')==1)
                                    {
                                        ?>
                                        <a class="btn btn-lg  btn-primary action_btn" data-action="by_grp" href="#"><i class="fa fa-users fa-2x pull-left"></i> User Reports</a>
                                        <a class="btn btn-lg btn-warning action_btn" data-action="by_project" href="#"><i class="fa fa-wrench fa-2x pull-left"></i> Platform Reports</a>
                                    <?php
                                    }
                                    ?>

                                    <a class="btn btn-lg btn-success action_btn" data-action="by_location" href="#"><i class="fa fa-map-marker fa-2x pull-left"></i> SMS Reports</a>


                                    <div class="result_area">
									<!--active user groups-->
                                        <div style="display: none;" class="usr_groups">
                                            <div class="widget widget-table">
                                             <div class="widget-header"><h3><i class="fa fa-magic"></i> User Reports</h3></div>
                                                <div class="widget-content">
                                                    <div class="message"></div>
                                                    <table class="table">
                                                        <thead>
                                                        	<tr>
                                                            	<th>Report Data</th>
                                                                <th>Report format</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        	<tr>
                                                            	<td>Subscribed numbers</td>
                                                                <td><a class="btn btn-xs btn-primary subscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/users_excel" target="_blank">Generate CSV</a> | <a class="btn btn-xs btn-danger unsubscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/Subscribers_pdf" target="_blank">Generate PDF</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            	<td>Unsubscribed numbers</td>
                                                                <td><a class="btn btn-xs btn-primary subscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/users_inactive_excel">Generate CSV</a> | <a class="btn btn-xs btn-danger unsubscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/Unsubscribers_pdf" target="new">Generate PDF</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: none;" class="usr_districts">
                                            <div class="widget widget-table">
                                             <div class="widget-header"><h3><i class="fa fa-magic"></i> SMS Reports</h3></div>
                                                <div class="widget-content">
                                                    <div class="messages"></div>
                                                    <table class="table">
                                                        <thead>
                                                        	<tr>
                                                            	<th>Report Data</th>
                                                                <th>Report format</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        	<tr>
                                                            	<td>Incoming SMS</td>
                                                                <td><a class="btn btn-xs btn-primary subscribe" href="#" target="_blank">Generate CSV</a> | <a class="btn btn-xs btn-danger unsubscribe" href="#" target="_blank">Generate PDF</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            	<td>Outgoing SMS</td>
                                                                <td><a class="btn btn-xs btn-primary subscribe" href="#">Generate CSV</a> | <a class="btn btn-xs btn-danger unsubscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/Outgoing_pdf" target="new">Generate PDF</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: none;" class="usr_projects">
                                            <div class="widget widget-table">
                                             <div class="widget-header"><h3><i class="fa fa-magic"></i> Platform Reports</h3></div>
                                                <div class="widget-content">
                                                    <div class="message"></div>
                                                    <table class="table">
                                                        <thead>
                                                        	<tr>
                                                            	<th>Report Data</th>
                                                                <th>Report format</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        	<tr>
                                                            	<td>Active platforms</td>
                                                                <td><a class="btn btn-xs btn-primary subscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/project_excel" target="_blank">Generate CSV</a> | <a class="btn btn-xs btn-danger unsubscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/Proj_pdf" target="_blank">Generate PDF</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            	<td>Inactive platforms</td>
                                                                <td><a class="btn btn-xs btn-primary subscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/project_inactive_excel">Generate CSV</a> | <a class="btn btn-xs btn-danger unsubscribe" href="<?=base_url().$this->uri->segment(1).'/reports'?>/Proj_inactive_pdf" target="new">Generate PDF</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- end right main content, the messages -->
                </div>
            </div>

        </div>

    <div class="message"></div>


    </div><!-- /main-content -->

    <script>
        $(document).ready(function()
        {
			//when major subscription types are clicked
            $('.action_btn').click(function(){
                //get value of action
                var btn_action=$(this).data('action');
                //alert(btn_action);
				
				//switch by action value
                switch (btn_action)
                {
                    //case of sub subscription by group
                    case 'by_grp':
                        $('.usr_groups').toggle();
						$('.usr_districts').hide();
						$('.usr_projects').hide();
						
						//hide div
						$('.action_btn').click(function(){
                            $('.usr_groups').hide();
							location.reload();
                        });
                        break;
					case 'by_project':
						$('.usr_projects').toggle();
						$('.usr_districts').hide();
						$('.usr_groups').hide();
						
						//hide div
						$('.action_btn').click(function(){
                            $('.usr_projects').hide();
							location.reload();
                        });
						break;
					case 'by_location':
						$('.usr_districts').toggle();
						$('.usr_projects').hide();
						$('.usr_groups').hide();
						
						//hide div
						$('.action_btn').click(function(){
                            $('.usr_districts').hide();
							location.reload();
                        });
						break;
                }
				
				return false;
            });			
		});
    </script>

