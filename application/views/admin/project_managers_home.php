
<div class="main-content">
    <!-- MODEL -->
    <div class="modal fade" id="modal-container-228144" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">
                        Modal title
                    </h4>
                </div>
                <div class="modal-body">
                    ...
                </div>

            </div>

        </div>
    </div>
    <!-- END -->
    <!-- TESTING -->

    <!-- END -->
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
                    <?=$this->load->view('admin/parts/inner_left_sidebar/project_menu')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?php
//print_r($managers);
                        //if there are usertypes
                        if(!empty($managers))
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
                                        <td>PLATFORM NAME</td>
                                        <td>MANAGER</td>
                                        <td>CONTACT</td>
                                        <td>OPTION</td>
                                    </tr>
                                    <tbody>
                                    <?php

                                    foreach($managers as $row)
                                    {
                              $dd = get_user_info_by_id($row['userid']);
                                        $data = $dd[0];

                                    //    print_array($row);
                              $prodd = get_project_by_type_id($row['projectid']);

                                        ?>
                                        <tr>
                                            <td><span class="from"><?=$prodd[0]['title']; ?></span></td>
                                            <td><span class="from"><?=$data['fname'].$data['lname'];?></span></td>
                                            <td>0<?=$data['tel'];?></td>
                                            <td>
                                                <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/project_managers/4/<?= $row['id'];?>"><i class="fa fa-trash-o"></i></a>

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
        <!-- END INBOX -->

    </div><!-- /main-content -->