<div class="col-md-2 left-sidebar">

    <!-- main-nav -->
    <nav class="main-nav">

        <ul class="main-menu">
            <?php
            //when users are logged in
            if($this->session->userdata('logged_in'))
            {
                ?>

                <!--            views for every one-->
                <li class="active"><a href="<?=base_url().$this->uri->segment(1).'/'?>dashboard"><i class="fa fa-dashboard fa-fw"></i><span class="text">Dashboard</span></a></li>

                <?php
                //views for super users and admins
                if(in_array(get_user_info_by_id($this->session->userdata('user_id'),'usertype_id'),$this->config->item('admins')))
                {
                    // find user type ::

                    if($this->session->userdata('logged_in_usertype')==1)
                    {
                        ?>
                        <li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-group"></i><span class="text">User Management</span>
                                <i class="toggle-icon fa fa-angle-left"></i></a>
                            <ul class="sub-menu ">
                                <li ><a href="<?=base_url().'admin/'?>usertypes"><span class="text">User Groups (<?=count(get_active_usertypes())?>)</span></a></li>
                                <li ><a href="<?=base_url().'admin/'?>users"><span class="text">Users (<?=count(get_active_users())?>)</span></a></li>
                            </ul>
                        </li>

                        <li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-folder fa-fw"></i><span class="text">Location management</span>
                                <i class="toggle-icon fa fa-angle-left"></i></a>
                            <ul class="sub-menu ">
                                <li ><a href="<?=base_url().'admin/'?>districts"><span class="text">Districts (<?=count(get_active_districts())?>)</span></a></li>
                                <li ><a href="<?=base_url().'admin/'?>sub_counties"><span class="text">Sub counties (<?=count(get_active_sub_counties())?>)</span></a></li>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>

                    <li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-clipboard fa-wrench"></i><span class="text">Manage Platforms</span>
                            <i class="toggle-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu ">
                            <li ><a href="<?=base_url().'admin/'?>projects"><span class="text">View Platforms</span></a></li>
                        </ul>
                    </li>
                    <li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-envelope fa-fw"></i><span class="text">SMS</span>
                            <i class="toggle-icon fa fa-angle-left"></i></a>
                        <ul class="sub-menu ">
                            <li ><a href="<?=base_url().'admin/feedback'?>"><span class="text">Feedback Management  </span></a></li>
                             <li ><a href="<?=base_url().'admin/'?>message_mgt/send"><span class="text">Message Management </span></a></li>
                        </ul>
                    </li>


                   <?php
                   if($this->session->userdata('logged_in_usertype')==1)
                   {	?>
                    	<li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-folder-open fa-fw"></i><span class="text">Content Management</span>
                            <i class="toggle-icon fa fa-angle-left"></i></a>
                            <ul class="sub-menu ">
                              <li ><a href="<?=base_url()?>admin/content/categories"><span class="text">Categories (<?=count(get_active_categories())?>)</span></a></li>
                            </ul>
                        </li>
                        <li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-book fa-fw"></i><span class="text">Reports</span>
                            <i class="toggle-icon fa fa-angle-left"></i></a>
                            <ul class="sub-menu ">
                               <li ><a href="<?=base_url().'admin/'?>reports"><span class="text">Reports</span></a></li>
                            </ul>
                        </li>
                    	<?php
                    }
                }
                else
                {

                }



                //views for logged in regular usres
                ?>

                <?php
            }
            else
            {
                //when not logged in
                ?>
                <!--            views for every one-->
                <li class="active"><a href="<?=base_url()?>"><i class="fa fa-home fa-fw"></i><span class="text">Home</span></a></li>
                <?php
                $categories=get_active_categories();
                foreach($categories as $category)
                {
                    ?>
                    <li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-bookmark"></i><span class="text"><?=ucwords($category['title'])?></span>
                            <i class="toggle-icon fa fa-angle-left"></i></a>
                        <?php
                        if(get_pages_by_category($category['id']))
                        {
                            ?>
                            <ul class="sub-menu ">

                                <?php
                                foreach(get_pages_by_category($category['id']) as $row)
                                {
                                    ?>
                                    <li ><a href="<?=base_url()?>view_page/<?=$category['slug'].'/'.$row['slug']?>"><span class="text"><?=$row['title']?></span></a></li>
                                    
                                    <?php
                                }
                                ?>

                            </ul>

                        <?php
                        }
                        ?>
                    </li>
                        <?php
                }
                ?>

            <?php
            }
            ?>
			<li ><a href="#" class="js-sub-menu-toggle"><i class="fa fa-globe fa-fw"></i><span class="text">External links</span>
                <i class="toggle-icon fa fa-angle-left"></i></a>
            	<ul class="sub-menu">
                	<li ><a href="http://budget.go.ug/" target="_blank"><span class="text">Budget website</span></a></li>
                    <li ><a href="http://216.104.206.216/acode/admin/" target="_blank"><span class="text">LGCSCI</span></a></li>
                </ul>
            </li>
        </ul>
    </nav><!-- /main-nav -->

    <div class="sidebar-minified js-toggle-minified">
        <i class="fa fa-angle-left"></i>
    </div>
    
    <!-- sidebar content -->
    <div class="sidebar-content">
        <div class="panel panel-default">
            <div class="panel-heading"><h5><i class="fa fa-lightbulb-o"></i> Tips</h5></div>
            <div class="panel-body">
                <p>You can do live search to the widget at search box located at top bar. It's very useful if your dashboard is full of widget.</p>
            </div>
        </div>

        <?php
    if($this->session->userdata('logged_in'))
    {
        ?>
        <?php
    }else
    {
        ?>
        <?php
    }
    ?>
    </div>
    <!-- end sidebar content -->
</div>
