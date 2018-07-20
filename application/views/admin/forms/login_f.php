<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 30/05/14
 * Time: 10:17
 *
 * login form
 */
?>
<?php
//if there are errors
if(isset($errors))
{
    ?>
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h3>Oh Snap!</h3>
        <?=$errors?>
    </div>
<?php
}
?>
<?php
$form_atr=array
(
    'id'        =>'login_form',
    'class'     =>'form-horizontal',
    'style'     =>'margin-bottom: 0px !important;',
    'role'      =>'form'
);
echo form_open(base_url().'admin/login',$form_atr)
?>

    <p class="title">Use your username or phone number</p>
    <div class="form-group">
        <label for="username" class="control-label sr-only">Username</label>
        <div class="col-sm-12">
            <div class="input-group">
                <input name="username" type="text" placeholder="username/phone number" class="form-control">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
            </div>
        </div>
    </div>
    <label for="password" class="control-label sr-only">Password</label>
    <div class="form-group">
        <div class="col-sm-12">
            <div class="input-group">
                <input name="password" type="password" placeholder="password" class="form-control">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            </div>
        </div>
    </div>
<input class="btn btn-custom-primary btn-lg btn-block btn-login" type="submit" class="btn btn-primary" name="login_usr" value="Log in" />


</form>


