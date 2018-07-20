<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/10/2014
 * Time: 2:09 PM
 */
//if there are no messages

?>
    <div class="main-content">
    <!-- INBOX -->
    <div class="inbox">

        <div class="top">
            <div class="bottom">
                    <div class="alert alert-dismissable alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <p>Login to use this feature</p>


                    </div>
                <div class="pick_url">

                    </div>


            </div>

        </div>
        <!-- END INBOX -->

    </div><!-- /main-content -->

        <script>
            $(document).ready(function()
            {
                var action_data =
                {
                    passed_url:'<?=current_url()?>',
                    from:'<?=$this->uri->segment(2)?>',
                    msg:'<?=$this->uri->segment(3)?>',
                    shortcode:'<?=$this->uri->segment(4)?>',
                    ajax:'current_url'
                };
                //loading gif
                $(".pick_url").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

                $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
                setInterval(function() {

                    var action_data =
                    {
                        passed_url:'<?=current_url()?>',
                        from:'<?=$this->uri->segment(2)?>',
                        msg:'<?=$this->uri->segment(3)?>',
                        shortcode:'<?=$this->uri->segment(4)?>',
                        ajax:'current_url'
                    };
                    //loading gif

                    $(".pick_url").html('<img src="<?=base_url()?>images/loading.gif" /> Now loading...');

                    $.ajax({
                        url: "<?php echo site_url($this->uri->segment(1)) ?>",

                        type: 'POST',
                        data: action_data,
                        success: function(msg) {

                            $('.pick_url').html(msg);

                            window.location.reload(true);


                        }
                    });

                    return false;

                }, 1000); // the "3000" here refers to the time to refresh the div.  it is in milliseconds.
                return false;

            })


        </script>