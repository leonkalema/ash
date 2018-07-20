<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/13/2014
 * Time: 11:00 PM
 */
?>
<div class="col-lg-6">
    <div class="widget">
        <div class="widget-header">
            <h3><?=ucwords(get_project_by_type_id(get_project_id_by_slug($this->uri->segment(3)),'title')).' | '.get_project_by_type_id(get_project_id_by_slug($this->uri->segment(3)),'shortcode')?></h3>
        </div>
        <div class="widget-content">
            <?=html_entity_decode(get_project_by_type_id(get_project_id_by_slug($this->uri->segment(3)),'description'))?>
        </div>
    </div>


    <div class="widget">
        <div class="widget-header">
            <h3><?=ucwords(get_project_by_type_id(get_project_id_by_slug($this->uri->segment(3)),'title')).' | '?>Incoming messages</h3>
        </div>
        <div class="widget-content">
            <?php 
            /*
            $m = $this->from_dump_yard_m->get_all($trashed='n');
            get_recieved_messages_by_shotcode
            print_r($m);
            */
            ?>
            <div class="vticker">
                <ul>
                    <?php
                        //Show specific project messages
                        $where=array
                        (
                            'shortcode'=>get_project_by_type_id(get_project_id_by_slug($this->uri->segment(3)),'shortcode'),
                            'trash'     =>'n',
                        );
                        $all_project_messages = $this->from_dump_yard_m->get_all();
                        if(!empty($all_project_messages))
                        {
                            foreach ($all_project_messages as $message) 
                            {
                                echo '<li>'.$message['msg'].'<br /><span style="font-size:10px">SMS BY: '.str_replace('256','0',$message['from']).'</span></li>';
                            }
                                        
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="widget">
        <div class="widget-header">
            <h3>Subscribe to <?=strtoupper($this->uri->segment(3))?></h3>
        </div>
        <div class="widget-content">
            <div class="widget-content" style="width:300px">
                <div class="message"></div>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="username" class="control-label sr-only">Telephone</label>
                        <div class="col-sm-12">
                            <input type="text" style="width:160px" class="form-control" maxlength="10" id="tel" placeholder="Enter your number">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-default subscribe">Subscribe</button>  <button type="submit" class="btn btn-default unsubscribe">Unsubscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.subscribe').click(function(){
       //alert('foo');
        //loading gif
        $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

        var tel        =$('#tel').val();

        var form_data =
        {

            tel :      tel,

            ajax:      'subscribe'
        };

        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
            type: 'POST',
            data: form_data,
            success: function(msg)
            {

                $('.message').html(msg);

            }
        });

        return false;

    });
    $('.unsubscribe').click(function(){
        //alert('foo');
        //loading gif
        $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

        var tel        =$('#tel').val();

        var form_data =
        {

            tel :      tel,
            ajax:      'unsubscribe'
        };

        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1).'/unsubscribe') ?>",
            type: 'POST',
            data: form_data,
            success: function(msg)
            {

                $('.message').html(msg);

            }
        });

        return false;

    });
</script>

