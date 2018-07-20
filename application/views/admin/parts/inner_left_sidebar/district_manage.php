<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <h3 class="sr-only">Manage <?=$this->uri->segment(2)?></h3>
    <ul class="list-unstyled left-menu">
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/add"><i class="fa fa-map-marker"></i> Add new</a></li>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>"><i class="fa fa-map-marker"></i> All districts<span class="badge pull-right"><?=count(get_active_districts())?></span></a></li>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/import"><i class="fa fa-file"></i> Import from Excel</a></li>
    </ul>


</div>