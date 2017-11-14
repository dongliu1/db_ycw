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

    /**
     * 连接数据库
     */
    public function connectDatabase(){
        $con=mysqli_connect($this->host, $this->dbuser, $this->dbpsw);
        if (!$con)
        {
            die('Could not connect: ' . mysqli_error($con));
        }
        if(!mysqli_select_db($con,$this->database)){
            die('Could not use '.$this->database);
        }else{
            return "True";
        }
    }

    /**
     * 导入sql文件
     */
    public function importSqlFile(){
        $_sql = file_get_contents('db_ycw.sql');
        $_arr = explode(';', $_sql);
        $_mysqli = new mysqli($this->host,$this->dbuser,$this->dbpsw);
        if (mysqli_connect_errno()) {
            exit('连接数据库出错');
        }
        foreach ($_arr as $_value) {
            $_mysqli->query($_value.';');
        }
        $_mysqli->close();
        $_mysqli = null;
    }

}