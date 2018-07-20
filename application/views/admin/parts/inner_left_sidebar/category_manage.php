<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <h3 class="sr-only">Manage <?=$this->uri->segment(2)?></h3>
    <ul class="list-unstyled left-menu">
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/add_category"><i class="fa fa-clipboard"></i> Add new category</a></li>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/categories"><i class="fa fa-map-marker"></i> All Categories<span class="badge pull-right"><?=count(get_active_categories())?></span></a></li>

        <?php
        if($this->uri->segment(3)=='pages')
        {
            ?>
            <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/new_page/<?=$this->uri->segment(4)?>"><i class="fa fa-clipboard"></i> Add new page</a></li>
        <?php
        }
        ?>

        <?php
        if($this->uri->segment(3)=='new_page')
        {
        ?>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/pages/<?=$this->uri->segment(4)?>"><i class="fa fa-clipboard"></i> View articles</a></li>
        <?php
        }
        ?>

    </ul>


</div>