<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 20:54
 */

class ycwServerControl extends ycwFuncControl
{
    public function __construct__()
    {
        parent::__construct__();
    }

    /***
     * 绑定邮箱
     * @telephone:手机号
     * @email:邮箱
     */
    public function bindEmail($param){

        $email=isset($param["email"])?$param["email"]:"";               //邮箱
        $tel=isset($param["telephone"])?$param["telephone"]:"";         //手机

        if($email==""||$tel=="")return "False";                         //传入参数不能为空

        $info=array("telephone"=>$tel);
        $res=$this->getUser($info);                                     //查询当前用户是否存在
        $res1="False";
        if($res){
            $con = mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);
            $sql = "INSERT INTO user_email (telephone, email) VALUES ('".$tel."','".$email."')";        //绑定邮箱
            $result = mysqli_query($con,$sql);
            if($result)$res1= "True";
            mysqli_close($con);
        }
        return $res1;
    }
}