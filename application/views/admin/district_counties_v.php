
<div class="main-content">

    <div class="inbox">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <!-- search box -->
                <?php //$this->load->view('admin/forms/search_box_f')?>
                <!-- end search box -->
            </div>
        </div>
        <div class="top">
            <div class="bottom">
                <div class="row">
                    <!-- inbox left menu -->
                    <?=$this->load->view('admin/parts/inner_left_sidebar/sub_county_manage')?>
                    <!-- end inbox left menu -->

                    <!-- right main content, the messages -->
                    <div class="col-xs-12 col-sm-9 col-lg-10">
                        <?php
                        echo $pages;
                        //if there are usertypes
                        if($all_sub_counties)
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
                                    foreach($all_sub_counties_paginated as $county)
                                    {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="simple-checkbox">
                                                    <input type="checkbox" id="checkbox10"><label for="checkbox10">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-star-o"></i></td>
                                            <td><span class="from"><?=ucwords($county['title'])?></span></td>
                                            <td class="text-left"><a href="<?=base_url().$this->uri->segment(1)?>/parishes/listing/<?=$county['slug']?>">Parishes (<?=count(get_parishes_by_sub_county($county['id']))?>)</a>&nbsp;&nbsp; <a href="<?=base_url().$this->uri->segment(1).'/parishes/add_to/'.$county['slug']?>"><i class="fa fa-plus"></i></a> </td>

                                            <td>&nbsp;</td>

                                            <td>&nbsp;</td>

                                            <td class="text-right">
                                                <a   href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/edit/<?=$county['slug']?>"  ><i class="fa fa-edit text-info"></i></a>
                                                <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/delete/<?=$county['slug']?>"><i class="fa fa-trash-o"></i></a>
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

                                <p>No subcounties to display</p>

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

