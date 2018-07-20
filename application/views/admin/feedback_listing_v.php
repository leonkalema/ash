
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
                    echo $pages;
                    //if there are usertypes
                    if(!empty($page_list))
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
                                    <td>
                                        <select class="form-control" name="select-district" id="select-district">
                                            <?php echo get_select_options($districts, 'id', 'title', '', 'Y', 'Select district'); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="subcounty" id="sub-county">
                                            <option value="">Select Sub-county</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="parish" id="select-parish">
                                            <option value="">Select Parish</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input id="search-feedback" name="search" type="button" value="search" class="btns" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>AUTHOR</td>
                                    <td>LOCATION</td>
                                    <td class="">MESSAGE</td>
                                    <td class="text-center">DATE</td>
                                </tr>
                                <tbody>
                                <?php
                                foreach($page_list as $row)
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="from">
                                                <?=ucwords($row['fname'].' '.$row['lname'])?>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
													<?php
                                                    $location_str = $row['district'];
                                                    $location_str .= (!empty($location_str) && !empty($row['subcounty'])? ', ' : '') . $row['subcounty'];
                                                    $location_str .= (!empty($location_str) && !empty($row['parish'])? ', ' : '') . $row['parish'];

                                                    echo $location_str;
                                                    ?>
                                            </span>
                                        </td>
                                        <td><span class="feedback_msg"><?=ucwords($row['message'])?></span></td>
                                        <td class="text-center"><span><?=custom_date_format('d M, Y',$row['dateadded']) ?></span></td>
                                        <td class="text-right">
                                            <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/delete/<?=$row['feedbackid']?>"><i class="fa fa-trash-o"></i></a>
                                        </td>
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

<script>
    $(document).ready(function()
    {
		$("#search-feedback-btn").click(function(){
				var form_data = { district: $('#select-district').val(),
								  subcounty: $('#sub-county').val(),
								  parish:$('#select-parish').val() };

				$(".messages").html('<div>Loading data...</div>');

				$.ajax({
					url: "<?php echo base_url() . 'admin/feedback/search'; ?>",
					type: 'POST',
					data: form_data,
					success: function(msg)
					{
						$('.messages').html(msg);
					}
				});

				return false;
			});

		$("#search-feedback-box").keyup(function(){
				var form_data = { search_msgs: $('#search-feedback-box').val() };

				$(".messages").html('<div>Loading data...</div>');

				$.ajax({
					url: "<?php echo base_url() . 'admin/feedback/search'; ?>",
					type: 'POST',
					data: form_data,
					success: function(msg)
					{
						$('.messages').html(msg);
					}
				});

				return false;
			});

        //dynamically load the sub counties
        $("#select-district").change(function(){
            //alert($("#usertype").val());
            $("#sub-county").html('<option selected>Loading sub counties...</option>');
            var district =$('#select-district').val();
            var form_data =
            {
                district:         district,
                ajax:        'get_counties'
            };

            $.ajax({
                url: "<?php echo base_url() . 'admin/feedback/display_subcounties'; ?>",
                type: 'POST',
                data: form_data,
                success: function(msg)
                {
                    $('#sub-county').html(msg);
                }
            });
        });


		$("#sub-county").on('change', function(){
				$("#select-parish").html('<option selected>Loading parishes...</option>');
				var subcounty =$('#sub-county').val();
				var form_data =
				{
					subcounty:         subcounty,
					ajax:        'get_parishes'
				};

				$.ajax({
					url: "<?php echo base_url() . 'admin/feedback/display_parishes'; ?>",
					type: 'POST',
					data: form_data,
					success: function(msg)
					{
						$('#select-parish').html(msg);
					}
				});

			});
    });

</script>
