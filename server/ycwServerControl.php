<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 20:54
 */

class ycwServerControl extends ycwFuncControl
{
    public $_sqlfile="";
    public $_sql=array();
    public function __construct()
    {
        parent::__construct();
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
        if (!$con) die('Could not connect: ' . mysqli_error($con));
        if(!mysqli_select_db($con,$this->database)){
            mysqli_set_charset($con,'utf8');                                //设置中文编码
            if (mysqli_query($con,"CREATE DATABASE ".$this->database)){
                mysqli_close($con);
                return "Creating Database Success";
            }else{
                mysqli_close($con);
                return "Creating Database Failed";
            }
        }else{
            return "True";
        }
    }

    /**
     * 导入sql文件
     */
    public function importSqlFile(){
        if(!file_exists($this->filename))
        {
            exit("文件".$this->filename."不存在！");
        }
        $this->_sqlfile = file_get_contents($this->filename);
        if(!$this->_sqlfile){
            exit("打开文件错误！");
        }else{
            $this->GetSqlArr();
            if ($this->Runsql())
                return true;
        }

    }

    /**
     * 获取sql语句数组
     *
     * @return void
     */
    public function GetSqlArr(){
        /** 去除注释 */
        $str = $this->_sqlfile;
        $str = preg_replace('/--.*/i', '', $str);
        $str = preg_replace('/\/\*.*\*\/(\;)?/i', '', $str);
        /** 去除空格 创建数组 */
        $str = explode(";", $str);

        foreach ($str as $v){
            $v = trim($v);
            if (empty($v)){
                continue;
            }else{
                array_push($this->_sql,$v);
            }
        }
    }

    /**
     * 执行sql文件
     *
     * @return true 执行成功返回true
     */
    public function Runsql(){

        /** 开启事务 */
        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        mysqli_query($con,'START TRANSACTION');                                         //开启事务
        mysqli_query($con,"SET AUTOCOMMIT=0");                                          //设置mysql不自动提交，需自行用commit语句提交
        mysqli_set_charset($con,'utf8');                                //设置中文编码
        if (mysqli_query($con,'BEGIN'))
        {
            foreach ($this->_sql as $k => $v)
            {
                if (!mysqli_query($con,$v))
                {
                    /** 回滚 */
                    mysqli_query($con,'ROLLBACK');
                    exit("sql语句错误：第" . $k . "行" . mysqli_error($con));
                }
            }
            /** 提交事务 */
            mysqli_query($con,'COMMIT');
            mysqli_query($con,"END"); //关闭事务
            mysqli_query($con,"SET AUTOCOMMIT=1");//设置mysql自动提交
            mysqli_close($con);                   //关闭数据库
            return true;
        }else{
            exit('无法开启事务！');
        }
    }


}