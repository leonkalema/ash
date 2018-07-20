<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <h3 class="sr-only">Manage <?=$this->uri->segment(2)?></h3>
    <ul class="list-unstyled left-menu">
        <li ><a href="<?=base_url().$this->uri->segment(1).'/parishes/add_to/'.$this->uri->segment(4)?>"><i class="fa fa-map-marker"></i> Add new parish</a></li>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/listing/<?=strtolower(seo_url(get_sub_county_by_id($sub_county,'title')))?>"><i class="fa fa-map-marker"></i> All <?=ucwords(get_sub_county_by_id($sub_county,'title'))?> parishes<span class="badge pull-right"><?=count(get_parishes_by_sub_county($sub_county))?></span></a></li>

    </ul>


</div>