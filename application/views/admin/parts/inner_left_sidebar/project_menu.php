<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <h3 class="sr-only">Inbox Menu</h3>
    <ul class="list-unstyled left-menu">
        <?php
        if($this->session->userdata('logged_in_usertype')==1)
        {
            ?>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/add"><i class="fa fa-user"></i> Add new platform</a></li>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/project_managers/9"><i class="fa fa-users"></i>View Platform Managers<span class="badge pull-right"></span></a></li>
        <?php
        }
        ?>

        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>"><i class="fa fa-users"></i>View Platforms<span class="badge pull-right"><?=count(get_active_projects())?></span></a></li>
        <hr>
        <?php
        //do display sub subcription sub menu
        if(get_project_id_by_slug($this->uri->segment(4)))
        {
            ?>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/add_subscribers/<?=$this->uri->segment(4)?>"><i class="fa fa-user"></i> Add new subscribers</a></li>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/add_subscribers/<?=$this->uri->segment(4)?>"><i class="fa fa-user"></i> Unsubscribe users <span class="badge pull-right"><?=count(get_subscribers_by_project($this->uri->segment(4)))?></span></a></li>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/registered/'.$this->uri->segment(4)?>"><i class="fa fa-user"></i> All subscribers <span class="badge pull-right"><?=count(get_subscribers_by_project($this->uri->segment(4)))?></span></a></li>
        <?php
        }
        ?>
    </ul>
</div>