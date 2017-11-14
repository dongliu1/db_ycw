<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 20:53
 */

class ycwFuncControl extends ycwControl
{

    public function __construct__()
    {
        parent::__construct__();
    }

    /***
     * 登录
     * @username:账号
     * @password:密码
     * @telephone:手机号
     ********/
    public function login($params){
        if(isset($params["isError"]))return "False";                   //请求前的格式检查

        $user = isset($params["username"])?$params["username"]:"";      //账号
        $tel  = isset($params["telephone"])?$params["telephone"]:"";    //手机
        $psw  = isset($params["password"])?$params["password"]:"";      //密码

        if($psw=="")return "False";                                     //密码为空
        if($user){                                                      //账号登录
            $sql="select * from user_account where account = '".$user."' and password = '".$psw."'";
        }else if($tel){                                                //手机登录
            $sql= "select * from user_account where telephone = '".$tel."' and password = '".$psw."'";
        }else{                                                          //账号与手机为空
            return "False";
        }
        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        $result = mysqli_query($con,$sql);                              //查询结果
        $rows=mysqli_num_rows($result);                                 //结果有多少行
        if($rows==1)return "True";                                      //登录成功
        return "False";                                                 //登陆失败
    }

    /***
     * 注册
     * @username:账号
     * @password:密码
     * @telephone:手机
     * @payPassword:支付密码
     * @qq:QQ号
     * @email:邮箱
     * @leader:推荐人
     * @userType:用户类型
     * @nickname:昵称
     ********/
    public function registration($params){

        $user=isset($params["username"])?$params["username"]:"";                        //账号
        $psw=isset($params["password"])?$params["password"]:"";                         //密码
        $tel=isset($params["telephone"])?$params["telephone"]:"";                       //手机
        $payPsw=isset($params["payPassword"])?$params["payPassword"]:"";                //支付密码
        $userType=isset($params["userType"])?$params["userType"]:"";                    //用户类型 0:商户 1:刷手
        $qq=isset($params["qq"])?$params["qq"]:"";                                      //QQ
        $email=isset($params["email"])?$params["email"]:"";                             //邮箱
        $leader=isset($params["leader"])?$params["leader"]:"";                          //推荐人
        $nickname=isset($params["nickname"])?$params["nickname"]:"";                    //昵称

        if($user == "" || $psw == "" || $tel == "" || $payPsw=="" ||$userType==""){     //必要参数
            return 'False';
        }else{
            $userInfo=array("username"=>$user);
            $userTel=array("telephone"=>$tel);
            $rslt1=$this->getUser($userInfo);                                           //账号是否已存在
            $rslt2=$this->getUser($userTel);                                            //手机号是否已存在
            if($rslt1=="False"&&$rslt2=="False"){
                $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
                mysqli_query($con,'START TRANSACTION');                                         //开启事务
                mysqli_query($con,"SET AUTOCOMMIT=0");                                          //设置mysql不自动提交，需自行用commit语句提交
                $sql1 = "INSERT INTO user_account (account, password,telephone,userType) VALUES ('".$user."','".$psw."','".$tel."','".$userType."')";
                $sql2 = "INSERT INTO user_info (telephone,payword,qq,leader,nickname) VALUES ('".$tel."','".$payPsw."','".$qq."','".$leader."','".$nickname."')";
                $sql3 = "INSERT INTO user_email(telephone,email) VALUES ('".$tel."','".$email."')";
                $res1 = mysqli_query($con,$sql1);                                               //向user_account表插入数据
                $res2 = mysqli_query($con,$sql2);                                               //向user_info表插入数据
                if($email)$res3=mysqli_query($con,$sql3);                                       //向user_email表插入数据
                if($res1 && $res2){
                    if($email&&!$res3){
                        mysqli_query($con,"ROLLBACK");                                      //失败回滚
                        $res= 'False';
                    }else{
                        mysqli_query($con,"COMMIT");                                        //成功提交
                        $res= "True";
                    }
                }else{
                    mysqli_query($con,"ROLLBACK");
                    $res= 'False';
                }
                mysqli_query($con,"END"); //关闭事务
                mysqli_query($con,"SET AUTOCOMMIT=1");//设置mysql自动提交
                mysqli_close($con);                   //关闭数据库
                return $res;
            }else{
                return "False";                         //手机号或账号已存在
            }

        }
    }

    /**
     *查询用户是否存在
     * @username:账号
     * @telephone:手机号
     */
    public function getUser($param){
        $user=isset($param["username"])?$param["username"]:"";                          //账号
        $tel=isset($param["telephone"])?$param["telephone"]:"";                         //手机号
        if($user==""&&$tel=="")return "False";                                          //参数错误
        if($user)$sql="select * from user_account where account = '".$user."'";         //账号查询
        if($tel) $sql="select * from user_account where telephone = '".$tel."'";        //手机号查询
        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        $result = mysqli_query($con,$sql);                              //查询结果
        $rows=mysqli_num_rows($result);                                 //结果有多少行
        if($rows==1)return "True";                                      //用户存在
        return "False";                                                 //用户不存在
    }

    /**
     *获取用户所有信息
     * @username:账号
     * @telephone:手机号
     */
    public function getUserInfo($param){
        $user=isset($param["username"])?$param["username"]:"";                          //账号
        $tel=isset($param["telephone"])?$param["telephone"]:"";                         //手机号

        if($user==""&&$tel=="")return "False";                                          //参数错误
        if($user)$sql="select * from user_account where account = '".$user."'";         //账号查询
        if($tel) $sql="select * from user_account where telephone = '".$tel."'";        //手机号查询
        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        $result = mysqli_query($con,$sql);                              //查询结果
        $rows=mysqli_num_rows($result);                                 //结果有多少行
        if($rows==1){
            $userInfo = array();
            while ($rows=mysqli_fetch_array($result)){
                $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
                for($i=0;$i<$count;$i++){
                    unset($rows[$i]);//删除冗余数据
                }
                array_push($userInfo,$rows);
            }

            $userTel=$userInfo[0]["telephone"];                                             //以手机号查询信息

            $sql1="select email from user_email WHERE telephone='".$userTel."'";
            $sql2="select * from user_info WHERE telephone='".$userTel."'";
            $res1 = mysqli_query($con,$sql1);                                               //查询用户邮箱信息
            $res2 = mysqli_query($con,$sql2);                                               //查询用户基本信息

            if($res1 && $res2){
                $res=$userInfo[0];                                                          //账号信息
                $res["email"]=array();                                                     //邮箱信息
                $rows1=mysqli_num_rows($res1);
                if($rows1>0){
                    while ($rows1=mysqli_fetch_array($res1)){
                        $count=count($rows1);
                        for($j=0;$j<$count;$j++){
                            unset($rows1[$j]);//删除冗余数据
                        }
                        array_push($res["email"],$rows1["email"]);                      //邮箱
                    }
                }
                $rows2=mysqli_num_rows($res2);
                if($rows2==1){
                    while ($rows2=mysqli_fetch_array($res2)){
                        $count=count($rows2);
                        for($k=0;$k<$count;$k++){
                            unset($rows2[$k]);
                        }
                        $res=array_merge($res,$rows2);                                  //信息合并
                    }
                }else{
                    $res= 'False';                                                      //未查询到相关用户信息
                }
            }else{
                $res= 'False';
            }
            mysqli_close($con);                   //关闭数据库
            return json_encode($res,JSON_UNESCAPED_UNICODE);
        }else{
            return "False";                                                 //用户不存在
        }
    }

    /***
     *修改密码
     * @username:账号
     * @telephone:手机号
     * @password:密码
     * @rePassword:新密码
     ********/
    public function modifyPassword($params){

        $user=isset($params["username"])?$params["username"]:"";                //账号
        $tel=isset($params["telephone"])?$params["telephone"]:"";               //手机
        $psw=isset($params["password"])?$params["password"]:"";                 //密码
        $rePsw=isset($params["rePassword"])?$params["rePassword"]:"";           //新密码

        if($psw=="")return "False";                                             //密码不能为空
        if($user){                                                              //账号、密码修改
            $sql1="SELECT * FROM user_account WHERE account='".$user."' AND password='".$psw."'";
            $sql2="UPDATE user_account SET password='".$rePsw."' WHERE account='".$user."' AND password='".$psw."'";
        }
        if($tel){                                                               //手机、密码修改
            $sql1="SELECT * FROM user_account WHERE telephone='".$tel."' AND password='".$psw."'";
            $sql2="UPDATE user_account SET password='".$rePsw."' WHERE telephone='".$tel."' AND password='".$psw."'";
        }

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        $result1 = mysqli_query($con,$sql1);                                        //查询当前用户是否存在
        $rows1=mysqli_num_rows($result1);
        $res="False";
        if($rows1==1){
            $result2 = mysqli_query($con,$sql2);                                    //更改当前用户密码
            if($result2)$res="True";
        }
        mysqli_close($con);
        return $res;
    }

    /**
     * 忘记密码
     * @telephone:手机号
     * @password:密码
     */
    public function modifyPasswordByTelephone($params){

        $tel=isset($params["telephone"])?$params["telephone"]:"";               //手机
        $psw=isset($params["password"])?$params["password"]:"";                 //密码

        if($tel==""||$psw=="")return "False";                                   //手机或密码不能为空

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        $sql1="SELECT * FROM user_account WHERE telephone='".$tel."'";
        $sql2="UPDATE user_account SET password='".$psw."' WHERE telephone='".$tel."'";
        $result1 = mysqli_query($con,$sql1);                                     //查询当前用户是否存在
        $rows1=mysqli_num_rows($result1);

        $res="False";
        if($rows1==1){
            $result2 = mysqli_query($con,$sql2);                                //修改当前用户密码
            if($result2)$res="True";
        }

        mysqli_close($con);
        return $res;

    }

    /**
     * 重置密码（管理员使用）
     * @telephone:手机号
     */
    public function resetPassword($params){

        $tel=isset($params["telephone"])?$params["telephone"]:"";               //手机

        if($tel=="")return "False";                                   //手机号不能为空

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        $sql="UPDATE user_account SET password='123456' WHERE telephone='".$tel."'";    //默认用户密码为123456
        $result=$this->getUser($params);                                                //查询用户是否存在
        if($result=="True")$result1 = mysqli_query($con,$sql);                                  //用户存在，重置密码
        mysqli_close($con);
        if($result=="True"&&$result1){                      //修改成功
            return "True";
        }else{                                      //修改失败
            return "False";
        }

    }

}