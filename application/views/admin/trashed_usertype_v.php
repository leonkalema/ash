<?php
//check for access
if($this->session->userdata('logged_in_usertype')==1)//if its a supper user
{
    ?>
    <div class="container">
        <div class="row">
            <?=$this->load->view('admin/parts/inner_left_sidebar/usertype_manage')?>
            <div class="col-md-9">


                <div class="panel panel-gray">

                    <div class="panel-heading">
                        <?php
                        //TODO make this realtime
                        ?>

                        <h4>
                            <div class="pull-right white">
                                <i class="fa fa-home"></i>Usertypes: <span class="badge badge-info"><?=count($all_usertypes)?></span>

                            </div>
                        </h4>
                        <div class="options">

                        </div>
                    </div>
                    <div class="panel-body">

                        <!--                    the spinner place holder div-->
                        <div id="spinner">

                        </div>



                        <div class="main_area">
                            <div class="panel panel-midnightblue">
                                <div class="panel-body">
                                    <?=$this->load->view('admin/forms/backend_src_f')?>
                                    <hr>
                                    <?php
                                    //if there user types
                                    if(count($all_usertypes)>0)
                                    {
                                        ?>
                                        <div class="spinner">

                                        </div>
                                        <div class="tbl_content">
                                            <table class="table table-striped table-advance table-hover mailbox">
                                                <thead>
                                                <tr>
                                                    <th width="5%"><span><input type="checkbox"></span></th>
                                                    <th colspan="1">
                                                        <div class="btn-group">
                                                            <a href="<?=base_url()?>admin/usertypes" class="btn btn-sm btn-midnightblue"><i class="fa fa-refresh"></i> Refresh</a>
                                                            <a class="btn btn-sm btn-default dropdown-toggle" href="#" data-toggle="dropdown"> Action <i class="fa fa-caret-down"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">Mark Read</a></li>
                                                                <li><a href="#">Mark Unread</a></li>
                                                                <li><a href="#">Junk</a></li>
                                                                <li><a href="#">Move</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </th>
                                                    <th colspan="4">
                                                        <div class="pull-right">
                                                            <?=$pages?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="tbl_rows">

                                                <?php
                                                foreach($all_usertypes_paginated as $type)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><span><input type="checkbox"></span></td>
                                                        <td class="hidden-xs"><?=ucwords($type['usertype'])?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">
                                                            <?php
                                                            if($type['id']!=1)
                                                            {
                                                                ?>
                                                                <a href="#" class="action_btn btn btn-xs " href="<?=$type['id']?>" data-id="<?=$type['id']?>" data-action="restore"  ><i class="fa fa-undo text-info"> Restore</i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th colspan="5">
                                                        <div class="pull-right">
                                                            <?=$pages?>
                                                        </div>
                                                    </th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    <?php

                                    }
                                    else
                                    {
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
                            </div>



                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        //when ann action butoon is clicked
        $('.action_btn').click(function(){
            //get model content
            var modal_title=$(this).data('title');
            var action=$(this).data('action');
            //alert(action);


            //replace the model title
            $("#myModalLabel").html(modal_title);

            //replace modal content
            $(".spinner").html('<img src="<?=base_url()?>images/loading.gif" /> please wait');

            //switch depending on action
            switch (action)
            {

                //when editing
                case 'edit_usertype':
                    //alert($(this).data('id'));
                    var activity_data=
                    {
                        ajax:action,
                        usertype_id:$(this).data('id')
                    }

                    $.ajax({
                        url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/edit') ?>",
                        type: 'POST',
                        data: activity_data,
                        success: function(msg)
                        {

                            $('.spinner').html(msg);

                        }
                    });
                    break;
                case 'delete_usertype':
                    var profile_data=
                    {
                        ajax:action,
                        usertype_id:$(this).data('id')
                    }
                    $.ajax({
                        url: "<?php echo site_url('admin/usertypes/ajax_calls') ?>",
                        type: 'POST',
                        data: profile_data,
                        success: function(msg)
                        {

                            $('.modal-body').html(msg);

                        }
                    });
                    break;
                case 'restore':
                    var profile_data=
                    {
                        ajax:action,
                        usertype_id:$(this).data('id')
                    }
                    $.ajax({
                        url: "<?php echo site_url('admin/usertypes/restore') ?>",
                        type: 'POST',
                        data: profile_data,
                        success: function(msg)
                        {

                            $('.spinner').html(msg);

                        }
                    });
                    break;
                //by default
                default :
                    $(".modal-body").html('<div class="alert alert-dismissable alert-info"><strong>Uh Oh!</strong>  No parameter passed to switch in trashed_usertype_v line 181<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> </div>');
            }
        });
    </script>
<?php
}
else
{
    //load acess denied page
    $this->load->view('admin/includes/access_denied');
}


