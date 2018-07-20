<div class="col-xs-12 col-sm-3 col-lg-2 inbox-left-menu">
    <h3 class="sr-only">Inbox Menu</h3>
    <ul class="list-unstyled left-menu">
    	<li ><a href="<?=base_url().'admin/'?>message_mgt/inbox"><i class="fa fa-inbox"></i> General feedback<span class="badge pull-right"></span></a></li>
        <li ><a href="<?=base_url().'admin/'?>message_mgt"><i class="fa fa-comment"></i> By project<span class="badge pull-right"></span></a></li>
        <li ><a href="<?=base_url().'admin/feedback'?>"><i class="fa fa-comments"></i>Filter feeback<span class="badge pull-right"></span></a></li>
        
        <h6>Export data</h6>
        	<li ><a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/Incoming_pdf" target="new"><i class="fa fa-folder-open"></i> Incoming Messages</a></li>
        <hr>
    </ul>
</div>