<?php
/*
#Author: Cengkuru Micheal
9/16/14
3:21 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <form class="form-horizontal" role="form">
            <fieldset>

                <div class="form-group">
                    <label for="usertype" class="col-sm-3 control-label">Sub county</label>
                    <div class="col-sm-6">
                        <input type="text" required=""    class="form-control" id="county" placeholder="sub county name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Districts</label>
                    <div class="col-sm-6">
                        <select id="district" class="form-control">
                            <option selected="" value="">Choose a district</option>
                            <?php
                            $usertypes=get_active_districts();
                            foreach($usertypes as $type)
                            {

                                ?>
                                <option  value="<?=$type['id']?>"><?=ucwords($type['title'])?></option>

                            <?php


                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="create" class="btn-primary btn  edit">Create</button>
                        <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>




<script>
    $(document).ready(function(){

        $('#create').click(function(){


            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

            var district    =$('#district').val();

            var county    =$('#county').val();


            var form_data =
            {
                district :          district,
                county :            county,
                ajax:               'add_sub_county_f'
            };

            $.ajax({
                url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
                type: 'POST',
                data: form_data,
                success: function(msg) {

                    $('.message').html(msg);

                }
            });
            return false;

        });
    });

</script>