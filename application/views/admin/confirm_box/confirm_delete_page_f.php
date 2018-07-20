<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/27/14
 * Time: 10:24 AM
 */
?>
<div class="panel panel-danger">
    <div class="panel-body conf_bdy">
        <div class="alert alert-dismissable alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h3>Warning!</h3>

            <p>Are you sure about deleting this?</p>
            <br>
            <p><a class="btn btn-danger delete" href="<?=$passed_id?>">Delete </a></p>

        </div>
    </div>
</div>

<script>
    $('.delete').click(function(){
        //get data values

        var passed_id='<?=$passed_id?>';

        var action_data =
        {
            passed_id:passed_id,
            ajax:'delete'
        };
        //loading gif
        $(".conf_bdy").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

        $.ajax({
            url: "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)) ?>",
            type: 'POST',
            data: action_data,
            success: function(msg) {

                $('.conf_bdy').html(msg);

                var count = 1;
                var countdown = setInterval(function(){
                    $("countdown").html(count + " seconds remaining!");
                    if (count == 0) {
                        clearInterval(countdown);
                        window.open("<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/categories", "_self");

                    }
                    count--;
                }, 500);//redirect after 500 milsecs

            }
        });

        return false;


    });
</script>