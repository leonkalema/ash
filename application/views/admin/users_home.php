
<div class="main-content">

    <div class="inbox">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <!-- search box -->
                <form class="searchbox">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" id="search" class="form-control" />
                        	<span class="input-group-btn">
                            	<button class="btn btn-primary" type="button"><i class="fa fa-search"></i> Search</button>
                            </span>
                    </div>
                </form>
                <!-- end search box -->
            </div>
        </div>
        <div class="top">
            <div class="bottom">
                <div class="row">
                    <!-- inbox left menu -->
                    <?=$this->load->view('admin/parts/inner_left_sidebar/user_manage')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?php
                        echo $pages;
                        //if there are usertypes
                        if($all_users)
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
                                    foreach($all_users_paginated as $user)
                                    {
                                        ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><i class="fa fa-star-o"></i></td>
                                            <!-- user types-->
                                            <td><span class="from"><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/usertype/'.seo_url(get_user_info_by_id($user['id'],'usertype'))?>"><?=ucwords(get_user_info_by_id($user['id'],'usertype'))?></a> </span></td>

                                            <td><span class="from"><img class="img-circle pull-left" width="32px" height="32px" src="<?=base_url()?>uploads/avatars/<?=get_thumbnail($user['avatar'])?>"> <a  style="padding: 10px;" href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/profile/<?=$user['slug']?>"><?=ucwords(get_user_info_by_id($user['id'],'firstname')==''?'(256) '.$user['tel']:get_user_info_by_id($user['id'],'fullname'))?></a></span></td>
                                            <td>&nbsp;</td>

                                            <td class="text-right">

                                                <a   href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/profile/<?=$user['slug']?>"  ><i class="fa fa-edit text-info"></i></a>
                                                <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/delete/<?=$user['slug']?>"><i class="fa fa-trash-o"></i></a>

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
                                <h3>Notice !</h3>

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
	<script>
	
	</script>
