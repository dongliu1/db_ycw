<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 20:51
 */
    header("content-type:text/html;charset=utf-8");         //设置编码
    ini_set('display_errors', '1');

    require_once("ycwControl.php");
    require_once("ycwFuncControl.php");
    require_once("ycwServerControl.php");

    $rqs=new ycwServerControl();

    eval("$"."ret= $"."rqs->".$_POST["method"]."(isset($"."_POST['params'])?$"."_POST['params']:'');");           //输出结果

    echo $ret;

?>