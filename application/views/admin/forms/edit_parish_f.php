<?php
/*
#Author: Cengkuru Micheal
9/16/14
3:21 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo $sub_county;

//print_array($parish_info);
foreach($parish_info as $row)
{
    $id     =$row['id'];
    $title  =$row['title'];
}

?>
<div class="widget">
    <div class="widget-header"><h3><i class="fa fa-edit"></i> <?=$pagetitle?></h3></div>
    <div class="widget-content">
        <div class="message">

        </div>
        <form class="form-horizontal" role="form">
            <fieldset>

                <div class="form-group">
                    <label for="parish" class="col-sm-3 control-label">Parish name</label>
                    <div class="col-sm-6">
                        <input type="text" required="" value="<?=ucwords($title)?>"    class="form-control" id="parish" placeholder="parish name">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="edit" class="btn-primary btn  edit">Edit</button>
                        <a href="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>" class="btn-default btn">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>




<script>
    $(document).ready(function(){

        $('#edit').click(function(){


            //loading gif
            $(".message").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

            var parish    =$('#parish').val();


            var form_data =
            {
                parish :            parish,
                id :                '<?=$id?>',
                ajax:               'edit_parish_f'
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