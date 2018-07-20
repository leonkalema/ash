
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
                    <!-- inbox left menu -->
                    <?=$this->load->view('admin/parts/inner_left_sidebar/project_menu')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <div class="widget">
                            <div class="widget-header"><h3><i class="fa fa-magic"></i> Mass Subscription</h3></div>

                                <div class="widget-content">

                                    <?php
                                    //print_array($this->session->all_userdata());
                                    if($this->session->userdata('logged_in_usertype')==1)
                                    {
                                        ?>
                                        <a class="btn btn-lg  btn-primary action_btn" data-action="by_grp" href="#"><i class="fa fa-users fa-2x pull-left"></i> By User group</a>
                                        <a class="btn btn-lg btn-warning action_btn" data-action="by_project" href="#"><i class="fa fa-wrench fa-2x pull-left"></i> By Other Project</a>
                                    <?php
                                    }
                                    ?>

                                    <a class="btn btn-lg btn-success action_btn" data-action="by_location" href="#"><i class="fa fa-map-marker fa-2x pull-left"></i> By User Location</a>

                                    <a class="btn btn-lg btn-info action_btn" data-action="by_telephone" href="#"><i class="fa fa-phone fa-2x pull-left"></i> By Telephone</a>

                                    <div class="result_area">
<!--                                        active user groups-->
                                        <div style="display: none;" class="usr_groups">
                                            <div class="widget widget-table">

                                                <div class="widget-header"><h3><i class="fa fa-table"></i> Current User groups (<?=count(get_active_usertypes())?>)</h3></div>
                                                <div class="widget-content">
                                                    <div class="message"></div>
                                                    <table class="table">
                                                        <thead>
                                                        <tr><th>Name</th><th>Members</th><th>Subscribe</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach(get_active_usertypes() as $usertype)
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td><?=ucwords($usertype['usertype'])?></td><td><?=count(get_users_by_usertype($usertype['id']))?></td><td><?=count(get_users_by_usertype($usertype['id']))>0?'<a class="btn btn-xs btn-primary subscribe" data-id="'.$usertype['id'].'" href="#"><i class="fa fa-plus"></i>Add</a>':'No members'?></td>

                                                                    <td><a class="btn btn-xs btn-danger unsubscribe" data-id="<?=$usertype['id']?>" href="#">Unsubscribe all</a> </td>

                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: none;" class="usr_districts">
                                            <div class="widget widget-table">

                                                <div class="widget-header"><h3><i class="fa fa-table"></i> Current Districts (<?=count(get_active_districts())?>)</h3></div>
                                                <div class="widget-content">
                                                    <div class="messages"></div>
                                                    <table class="table">
                                                        <thead>
                                                        <tr><th>Districts</th><th>Members</th><th>Subscribe</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach(get_active_districts() as $district)
                                                        {
                                                            ?>
                                                            <tr><td><?=ucwords($district['title'])?></td><td><?=count(get_users_by_district($district['id']))?></td><td><?=count(get_users_by_district($district['id']))>0?'<a class="btn btn-xs btn-primary subscribe_district" data-id="'.$district['id'].'" href="#"><i class="fa fa-plus"></i>Add</a> <a class="btn btn-xs btn-danger unsubscribe_district" data-id="'.$district['id'].'" href="#">Unsubscribe all</a> ':'No members'?></td></tr>
                                                        <?php
                                                        }
                                                        ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: none;" class="usr_projects">
                                            <div class="widget widget-table">
                                                <?php
                                                //display only if there are other projects
                                                if(count(get_active_projects())>1)
                                                {
                                                    ?>
                                                    <div class="widget-header"><h3><i class="fa fa-table"></i> Current Platforms (<?=count(get_active_projects())?>)</h3></div>
                                                    <div class="widget-content">
                                                        <div class="messages"></div>
                                                        <table class="table">
                                                            <thead>
                                                            <tr><th>Project</th><th>Members</th><th>Subscribe</th></tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach(get_active_projects() as $project)
                                                            {
                                                                //dont show current project
                                                                if($project['id']!=get_project_id_by_slug($this->uri->segment(4)))
                                                                {
                                                                    //print_array(get_active_projects());
                                                                    ?>
                                                                    <tr>
                                                                        <td><?=$project['title']?>
                                                                        <td><?=count(get_users_by_project($project['id']))?></td>

                                                                        <?php
                                                                        if(count(get_users_by_project($project['id'])))
                                                                        {
                                                                            ?>
                                                                            <td><a class="btn btn-xs btn-primary subscribe_project" data-id="<?=$project['id']?>" href="#"><i class="fa fa-plus"></i>Add</a> <a class="btn btn-xs btn-danger unsubscribe_project" data-id="<?=$project['id']?>" href="#">Unsubscribe all</a> </td>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <td>No members</td>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                    </tr>
                                                                <?php
                                                                }

                                                            }
                                                            ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php

                                                }
                                                else
                                                {
                                                    ?>
                                                    <div class="alert alert-warning alert-dismissable">
                                                        <a href="" class="close">×</a>
                                                        <strong>Warning!</strong> There is no other project
                                                    </div>
                                                <?php
                                                }
                                                ?>


                                            </div>
                                        </div>

                                        <div style="display: none;" class="usr_telephones">
                                            <div class="widget widget-table">

                                                <div class="widget-header"><h3><i class="fa fa-table"></i> Subscribe by telephone number</h3></div>
                                                <div class="widget-content">
                                                    <div class="messages"></div>

                                                    <a class="btn btn-custom-primary manual" href="#">Manual Insert</a>
                                                    <a class="btn btn-custom-secondary excel" href="#">Import excel</a>

                                                    <div style="display: none;" class="manual_add">
                                                        <?=$this->load->view('admin/forms/add_user_by_tel_f')?>

                                                    </div>

                                                    <div style="display: none;" class="excel_import">
                                                        <?=$this->load->view('admin/forms/upload_users_csv_f')?>
                                                    </div>



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
						$('.usr_telephones').hide();
						$('.usr_projects').hide();
						
                        $('.action_btn').click(function(){
						   $('.usr_groups').hide();
                           location.reload();
                        });
                        //when add is clicked
                        $('.subscribe').click(function(){
							$('').hide();
                            var usr_grp=$(this).data('id');
                            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
                            //alert(usr_grp);
                            var form_data =
                            {
                                usr_grp :            usr_grp,
                                project_slug:         '<?=$this->uri->segment(4)?>',
                                ajax:               'subscribe_by_group'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg) {

                                    $('.message').html(msg);

                                }
                            });
                        });

                        //when unsubscribe is clicked
                        $('.unsubscribe').click(function(){
                            var usr_grp=$(this).data('id');
                            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
                            //alert(usr_grp);
                            var form_data =
                            {
                                usr_grp :            usr_grp,
                                project_slug:         '<?=$this->uri->segment(4)?>',
                                ajax:               'unsubscribe_by_group'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg) {

                                    $('.message').html(msg);

                                }
                            });
                        });

                        break;
                    case 'by_location':
						$('.usr_districts').toggle();
						$('.usr_groups').hide();
						$('.usr_telephones').hide();
						$('.usr_projects').hide();
						
                        $('.action_btn').click(function(){
                            $('.usr_districts').hide();
							location.reload();

                        });
                        $('.subscribe_district').click(function(){

                            //alert('subscribe_district');
                            var district_id=$(this).data('id');
                            $(".messages").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
                            //alert(district_id);

                            var form_data =
                            {
                                district :            district_id,
                                project_slug:         '<?=$this->uri->segment(4)?>',
                                ajax:               'subscribe_by_district'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg) {

                                    $('.messages').html(msg);

                                }
                            });



                        });

                        //when unsubscribe is clicked
                        $('.unsubscribe_district').click(function(){
                            var district=$(this).data('id');
                            $(".messages").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
                            //alert(usr_grp);
                            var form_data =
                            {
                                district :            district,
                                project_slug:         '<?=$this->uri->segment(4)?>',
                                ajax:               'unsubscribe_by_district'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg) {

                                    $('.message').html(msg);

                                }
                            });
                        });

                        break;

                    case 'by_project':
						$('.usr_projects').toggle();
						$('.usr_groups').hide();
						$('.usr_telephones').hide();
						$('.usr_districts').hide();
					
                        $('.action_btn').click(function(){
                            $('.usr_projects').hide();
							location.reload();
                        });

                        $('.subscribe_project').click(function(){

                            //alert('subscribe_district');
                            var project_id=$(this).data('id');
                            $(".messages").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
                            //alert(district_id);

                            var form_data =
                            {
                                project :            project_id,
                                project_slug:         '<?=$this->uri->segment(4)?>',
                                ajax:               'subscribe_by_project'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg) {

                                    $('.messages').html(msg);

                                }
                            });



                        });


                        //when unsubscribe is clicked
                        $('.unsubscribe_project').click(function(){
                            var district=$(this).data('id');
                            $(".messages").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');
                            //alert(usr_grp);
                            var form_data =
                            {
                                district :            district,
                                project_slug:         '<?=$this->uri->segment(4)?>',
                                ajax:               'unsubscribe_by_project'
                            };

                            $.ajax({
                                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                                type: 'POST',
                                data: form_data,
                                success: function(msg) {

                                    $('.message').html(msg);

                                }
                            });
                        });


                        break;

                    case 'by_telephone':
						$('.usr_telephones').toggle();
						$('.usr_groups').hide();
						$('.usr_projects').hide();
						$('.usr_districts').hide();
					
                        $('.action_btn').click(function(){
                            $('.usr_telephones').hide();
							location.reload();
                        });

                        $('.excel').click(function(){
                            $('.excel_import').show();

                            $('.manual_add').hide();
                        });

                        $('.manual').click(function(){
                            $('.manual_add').show();
                            $('.excel_import').hide();
                        });

                        break;


                }

                return false;
            });

            //
        })
    </script>

