<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 12/9/2014
 * Time: 4:45 PM
 */
function validate_telephone($tel)
{
    if(!is_numeric($tel))
    {
        return FALSE;
    }
    elseif(strlen($tel)<>10)
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}