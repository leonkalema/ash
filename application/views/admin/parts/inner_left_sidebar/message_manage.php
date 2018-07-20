<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <ul class="list-unstyled left-menu">
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/send_by_num"><i class="fa fa-phone"></i> Send by number</a></li>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/from_excel"><i class="fa fa-file"></i> Send from Excel</a></li>
        <li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/send_by_project"><i class="fa fa-wrench"></i> Send by project</a></li>
		<li ><a href="<?=base_url().'admin/'?>message_mgt/sent_items"><i class="fa fa-external-link"></i> Sent messages</a></li>
    </ul>
</div>