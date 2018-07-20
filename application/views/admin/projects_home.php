
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
                        echo $pages;
                        //if there are usertypes
                        if($all_projects)
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
                                        <td>SHORT CODE</td>
                                        <td>PLATFORM DETAILS</td>
                                        <td>SUBSCRIBERS</td>
                                    </tr>
                                    <tbody>
                                    <?php
                                    if($this->session->userdata('logged_in_usertype')==1)
                                    {
                                        foreach ($all_projects_paginated as $projects) {
                                            ?>
                                            <tr>
                                                <td><span class="from"><?= ucwords($projects['title']) ?></span></td>
                                                <td align="center" ><?= $projects['shortcode'] ?></td>
                                                <td><?= $projects['projectdetails'] ?></td>
                                                <td><a style="padding: 10px;"
                                                       href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) ?>/registered/<?= $projects['slug'] ?>">Click
                                                        to view</a></td>
                                                <td class="text-right">
                                                    <a href="javascript:p_addusers('<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) ?>/project_managers/7/<?= $projects['id']; ?>');"><i
                                                            class="fa fa-user"></i></a>
                                                    <a href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) ?>/edit/<?= $projects['slug'] ?>"><i
                                                            class="fa fa-edit text-info"></i></a>
                                                    <a href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) ?>/delete/<?= $projects['slug'] ?>"><i
                                                            class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                    elseif($this->session->userdata('logged_in_usertype')==2)
                                    {
                                        foreach ($all_projects as $projects)
                                        {
                                            ?>
                                            <tr>
                                                <td class="pnt"><span class="from"><?= ucwords($projects['title']) ?></span></td>
                                                <td class="pnt"><?= $projects['shortcode'] ?></td>
                                                <td class="pnt"><?= $projects['projectdetails'] ?></td>
                                                <td ><a style="padding: 10px;"
                                                        href="<?= base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) ?>/registered/<?= $projects['slug'] ?>">Click
                                                        to view</a></td>

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
                            //if there are no user types
                            ?>
                            <div class="alert alert-dismissable alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h3>Notice !</h3>

                                <p>No projects to display</p>

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