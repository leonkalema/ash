
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
                        if($all_districts)
                        {
                            ?>
                            <div class="messages">
                                <table class="table-condensed message-table" width="100%" cellpadding="0" cellspacing="0">

                                    <tbody>
                                    <?php
                                    foreach($all_districts_paginated as $district)
                                    {
                                        ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td style="width: 300px"><span class="justify"><?=ucwords($district['title'])?></span></td>
                                            <td><span class="from"><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/district/'.$district['slug']?>">sub counties (<?=count(get_sub_country_by_district($district['id']))?>)</a></span></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>

                                            <td class="text-right">

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

