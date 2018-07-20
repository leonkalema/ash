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
                    <label for="usertype" class="col-sm-3 control-label">Telephone</label>
                    <div class="col-sm-6">
                        <input type="text" required="" class="form-control" id="tel" placeholder="enter telephone number">
                        <!--
                        <select id="ms" multiple="multiple">
                            <option disabled="disabled" selected="selected"></option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        -->
                    </div>
                </div>

                <div class="form-group">
                    <label for="usertype" class="col-sm-3 control-label">Salutation</label>
                    <div class="col-sm-6">
                        <input type="text" required=""    class="form-control" id="salutation" placeholder="enter salutation"><p>(optional)</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="usertype" class="col-sm-3 control-label">Message</label>
                    <div class="col-sm-6">
                        <textarea class="form-control " id="content" name="ticket-message" rows="5" cols="30" placeholder="Message"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="usertype" class="col-sm-3 control-label">Reply instructions</label>
                    <div class="col-sm-6">
                        <input type="text" required="" class="form-control" id="instructions" placeholder="how users should reply"><p>(optional)</p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button id="create" class="btn-primary btn  edit">Send</button>
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

            var tel             =$('#tel').val();
            var salutation      =$('#salutation').val();
            var content         =$('#content').val();
            var instructions    =$('#instructions').val();


            var form_data =
            {
                tel:        tel,
                salutation: salutation,
                content:    content,
                instructions:       instructions,
                ajax:           'send_by_tel'
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
<script>
    $(function() {
        $('#ms').change(function() {
            console.log($(this).val());
        }).multipleSelect({
            width: '100%'
        });
    });
</script>