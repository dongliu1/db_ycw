<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 20:53
 */

class ycwFuncControl extends ycwControl
{
    public function __construct()
    {
        parent::__construct();
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
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        $result = mysqli_query($con,$sql);                              //查询结果
        if(!$result)return "False";                                    //操作失败
        $rows=mysqli_num_rows($result);                                 //结果有多少行
        if($rows==1)return "True";                                     //登录成功
        return "False";                                                //登陆失败
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
        $nickname=isset($params["nickname"])?$params["nickname"]:$user;                 //昵称

        if($user == "" || $psw == "" || $tel == "" || $payPsw=="" ||$userType==""){     //必要参数
            return 'False';
        }else{
            $userInfo=array("username"=>$user);
            $userTel=array("telephone"=>$tel);
            $rslt1=$this->getUser($userInfo);                                           //账号是否已存在
            $rslt2=$this->getUser($userTel);                                            //手机号是否已存在
            if($rslt1=="False"&&$rslt2=="False"){
                $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
                if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
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
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        $result = mysqli_query($con,$sql);                              //查询结果
        if(!$result)return "False";                                    //查询失败
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
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        $result = mysqli_query($con,$sql);                              //查询结果
        if(!$result)return "False";                                      //查询失败
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
            return str_replace("\\/", "/", json_encode($res,JSON_UNESCAPED_UNICODE));
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
        if (!$con)die('Could not connect: ' . mysqli_error($con));                  //连接失败
        $result1 = mysqli_query($con,$sql1);                                        //查询当前用户是否存在
        if(!$result1)return "False";                                                //查询失败
        $rows1=mysqli_num_rows($result1);                                           //用户数量
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
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
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
        if (!$con)die('Could not connect: ' . mysqli_error($con));                      //连接失败
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

    /**
     * 交易
     * transact:recharge(充值)，consumer(消费)
     * @param $params
     * @return string
     */
    public function transact($params){
        $transact  = isset($params["transact"])?$params["transact"]:"";
        $telephone = isset($params["telephone"])?$params["telephone"]:"";
        $amount    = isset($params["amount"])?(int)$params["amount"]:"";
        if($amount>0&&$telephone!=""&&($transact=="recharge"||$transact=="consumer")){
            $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
            if (!$con)die('Could not connect: ' . mysqli_error($con));                  //连接失败
            $sql="SELECT asset FROM user_info WHERE telephone='$telephone'";
            $result = mysqli_query($con,$sql);                                          //查询当前用户余额
            if($result){
                $rows=mysqli_num_rows($result);                                           //查询结果记录条数
                if($rows==1){
                    $userAsset = 0;
                    while ($rows=mysqli_fetch_array($result)){
                        $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
                        for($i=0;$i<$count;$i++){
                            unset($rows[$i]);//删除冗余数据
                        }
                        $userAsset=(int)$rows["asset"];
                    }

                    if($transact=="recharge"){
                        $userAsset+=$amount;
                        $dealType=0;
                    }else{
                        $userAsset-=$amount;
                        $dealType=1;
                    }
                    if($userAsset>=0){
                        list($msec, $sec) = explode(' ', microtime());
                        $dealTime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000); //当前时间unix时间戳

                        mysqli_query($con,'START TRANSACTION');                                         //开启事务
                        mysqli_query($con,"SET AUTOCOMMIT=0");                                          //设置mysql不自动提交，需自行用commit语句提交
                        $sql1="UPDATE user_info SET asset='$userAsset' WHERE telephone='$telephone'";
                        $sql2="INSERT INTO deal_records(useid,dealType,dealTime,dealAmount) VALUES('$telephone','$dealType','$dealTime','$amount')";
                        $result1 = mysqli_query($con,$sql1);                                          //更新当前用户余额
                        $result2 = mysqli_query($con,$sql2);                                          //添加交易记录
                        if($result1&&$result2){
                            $res="True";
                            mysqli_query($con,"COMMIT");                                      //成功提交
                        }else{
                            $res="False";
                            mysqli_query($con,"ROLLBACK");                                      //失败回滚
                        }
                        mysqli_query($con,"END"); //关闭事务
                        mysqli_query($con,"SET AUTOCOMMIT=1");//设置mysql自动提交
                    }else{
                        $res="False";
                    }
                }else{
                    $res="False";
                }
            }else{
                $res="False";
            }
            mysqli_close($con);
            return $res;
        }else{
            return "False";
        }
    }

    /****
     * 查询账户余额
     * @param $params
     * @return string
     */
    public function getAsset($params){
        $telephone=isset($params["telephone"])?$params["telephone"]:"";
        if(!$telephone)return "False";
        $sql="SELECT asset FROM user_info WHERE telephone='$telephone'";
        $asset=$this->msql_select($sql);
        return json_encode($asset,JSON_UNESCAPED_UNICODE);
    }

    /****
     * 查询交易信息
     * @param $params
     * @return string
     */
    public function getDealRecord($params){
        $telephone = isset($params["telephone"])?$params["telephone"]:"";
        $beginTime = isset($params["beginTime"])?$params["beginTime"]:"";
        $endTime   = isset($params["endTime"])?$params["endTime"]:"";

        if($telephone==""||$beginTime==""||$endTime=="")return "False";

        $sql="SELECT dealAmount,dealTime,dealType FROM deal_records WHERE userid='$telephone' AND dealTime>=$beginTime AND dealTime<=$endTime";
        $asset=$this->msql_select($sql);
        return json_encode($asset,JSON_UNESCAPED_UNICODE);
    }

    /***
     * 删除交易记录
     * @param $params
     * @return string
     */
    public function deleteDealRecord($params){

        $beginTime = isset($params["beginTime"])? (int)$params["beginTime"]:"";
        $endTime   = isset($params["endTime"])  ? (int)$params["endTime"]:"";

        if($beginTime==""&&$endTime==""){                           //不传值，删除全部记录
            $sql="DELETE FROM deal_records";
        }else if($beginTime==""&&$endTime>0){                       //只传入结束时间,删除结束时间以前的记录
            $sql="DELETE FROM deal_records dealTime<='$endTime'";
        }else if($beginTime>0&&$endTime>0&&$beginTime<$endTime){    //删除开始时间到结束时间的记录
            $sql="DELETE FROM deal_records WHERE dealTime>='$beginTime' AND dealTime<='$endTime'";
        }else{                                                      //参数不符合规范
            return "False";
        }

        if($this->msql_execute($sql)){          //删除成功
            return "True";
        }else{                                  //删除失败
            return "False";
        }
    }

    /**
     * 发布任务
     * @userAccount $user:用户账号
     */
    public function createTask($params){
        $user             =  isset($params["username"])?$params["username"]:"";                //发布人
        $taskName         =  isset($params["taskName"])?$params["taskName"]:"";                //任务名称
        $payType          =  isset($params["payType"])?$params["payType"]:"";                  //付款方式
        $platformType     =  isset($params["platformType"])?$params["platformType"]:"";        //发布平台类型
        $shopName         =  isset($params["shopName"])?$params["shopName"]:"";                //店铺名称
        $equipment        =  isset($params["equipment"])?$params["equipment"]:"";              //设备
        $keywords         =  isset($params["keywords"])?$params["keywords"]:array();          //搜索关键词  例如:["鞋子","男士"]

        $fileUrl          =  isset($params["fileUrl"])?$params["fileUrl"]:"";                  //任务图片地址

        $linkAddress      =  isset($params["linkAddress"])?$params["linkAddress"]:"";           //商品链接地址
        $credibilityLevel =  isset($params["credibilityLevel"])?$params["credibilityLevel"]:""; //买号信誉等级要求
        $taskCommission   =  isset($params["taskCommission"])?$params["taskCommission"]:"";     //任务佣金
        $taskCode         =  isset($params["taskCode"])?$params["taskCode"]:array();            //地区行政编码  例如:["201","302"]
        $integral         =  isset($params["integral"])?$params["integral"]:"";                 //任务点数
        $timeOfReceipt    =  isset($params["timeOfReceipt"])?$params["timeOfReceipt"]:"";       //好评时间要求
        $commentOfReceipt =  isset($params["commentOfReceipt"])?$params["commentOfReceipt"]:""; //好评内容要求
        $orders           =  isset($params["orders"])?$params["orders"]:"";                     //任务接受状态

        if($orders==""||$commentOfReceipt==""||$timeOfReceipt==""||$integral==""||$fileUrl==""||$user==""
            ||$taskName==""||$shopName==""||$linkAddress==""||$credibilityLevel==""
            ||$payType==""||$platformType==""||!(int)$taskCommission||!is_array($taskCode)
            ||!count($taskCode)||!is_array($keywords))return "False";        //参数不符合要求

        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $taskId=$user."_".$msectime;


        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        mysqli_query($con,'START TRANSACTION');                                         //开启事务
        mysqli_query($con,"SET AUTOCOMMIT=0");                                          //设置mysql不自动提交，需自行用commit语句提交
        mysqli_set_charset($con,'utf8');                                                //设置中文编码
        $sql1 = "INSERT INTO user_task (id, taskName,modifiTime,author) VALUES ('$taskId','$taskName','$msectime','$user')";
        $sql2 = "INSERT INTO task_info (
                      id,payType,orders,commentOfReceipt,timeOfReceipt,platformType,
                      integral,shopName,equipment,fileUrl,linkAddress,
                      credibilityLevel,taskCommission
                      ) VALUES (
                      '$taskId','$payType','$orders','$commentOfReceipt','$timeOfReceipt','$platformType',
                      '$integral','$shopName','$equipment','$fileUrl','$linkAddress',
                      '$credibilityLevel','$taskCommission')";
        //echo $sql1."---------------".$sql2;
        $res1 = mysqli_query($con,$sql1);                                               //向user_task表插入数据
        $res2 = mysqli_query($con,$sql2);                                               //向task_info表插入数据

        if($res1 && $res2){
            $res= 'True';
            foreach($taskCode as $code){
                $sql3 = "INSERT INTO task_code(id,code) VALUES ('".$taskId."','".$code."')";
                if(!mysqli_query($con,$sql3)){
                    mysqli_query($con,"ROLLBACK");                                      //失败回滚
                    $res= 'False';
                    break;
                }
            }
            foreach($keywords as $word){
                $sql4 = "INSERT INTO task_keyword(id,keyword) VALUES ('".$taskId."','".$word."')";
                if(!mysqli_query($con,$sql4)){
                    mysqli_query($con,"ROLLBACK");                                      //失败回滚
                    $res= 'False';
                    break;
                }
            }
            if($res == 'True')mysqli_query($con,"COMMIT");                               //成功提交
        }else{
            mysqli_query($con,"ROLLBACK");
            $res= 'False';
        }
        mysqli_query($con,"END"); //关闭事务
        mysqli_query($con,"SET AUTOCOMMIT=1");//设置mysql自动提交
        mysqli_close($con);                   //关闭数据库
        return $res;
    }

    /**
     * 修改任务
     * @param $params
     * @return string
     */
    public function updateTask($params){
        $taskId           =  isset($params["taskId"])?$params["taskId"]:"";
        if($taskId=="")return "False";

        $taskName         =  isset($params["taskName"])?$params["taskName"]:"";                //任务名称
        $payType          =  isset($params["payType"])?$params["payType"]:"";                  //付款方式
        $platformType     =  isset($params["platformType"])?$params["platformType"]:"";        //发布平台
        $shopName         =  isset($params["shopName"])?$params["shopName"]:"";                //店铺名称
        $equipment        =  isset($params["equipment"])?$params["equipment"]:"";              //设备
        $keywords         =  isset($params["keywords"])?$params["keywords"]:array();          //搜索关键词  例如:["鞋子","男士"]

        $fileUrl          =  isset($params["fileUrl"])?$params["fileUrl"]:"";                  //任务图片地址

        $linkAddress      =  isset($params["linkAddress"])?$params["linkAddress"]:"";           //商品链接地址
        $credibilityLevel =  isset($params["credibilityLevel"])?$params["credibilityLevel"]:""; //买号信誉等级要求
        $taskCommission   =  isset($params["taskCommission"])?$params["taskCommission"]:"";     //任务佣金
        $taskCode         =  isset($params["taskCode"])?$params["taskCode"]:array();            //地区行政编码  例如:["201","302"]
        $integral         =  isset($params["integral"])?$params["integral"]:"";                 //任务点数
        $timeOfReceipt    =  isset($params["timeOfReceipt"])?$params["timeOfReceipt"]:"";       //好评时间要求
        $commentOfReceipt =  isset($params["commentOfReceipt"])?$params["commentOfReceipt"]:""; //好评内容要求
        $orders           =  isset($params["orders"])?$params["orders"]:"";                     //任务接受状态


        if($orders==""||$commentOfReceipt==""||$timeOfReceipt==""||$integral==""||
            $fileUrl==""||$taskName==""||$shopName==""||$linkAddress==""||
            $credibilityLevel==""||$payType==""||$platformType==""||
            !(int)$taskCommission||!is_array($taskCode)||!count($taskCode)||!is_array($keywords))return "False";        //参数不符合要求

        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        mysqli_query($con,'START TRANSACTION');                                         //开启事务
        mysqli_query($con,"SET AUTOCOMMIT=0");                                          //设置mysql不自动提交，需自行用commit语句提交
        mysqli_set_charset($con,'utf8');                                                //设置中文编码
        $sql1 = "UPDATE user_task SET taskName='$taskName', modifiTime='$msectime' WHERE id='$taskId'";
        $sql2="UPDATE task_info SET orders='$orders', commentOfReceipt='$commentOfReceipt', timeOfReceipt='$timeOfReceipt', 
              integral='$integral', payType='$payType', platformType='$platformType', shopName='$shopName', equipment='$equipment',
               fileUrl='$fileUrl', linkAddress='$linkAddress', credibilityLevel='$credibilityLevel', 
               taskCommission='$taskCommission' WHERE id='$taskId'";
        $res1 = mysqli_query($con,$sql1);                                               //向user_task表更新数据
        $res2 = mysqli_query($con,$sql2);                                               //向task_info表更新数据

        if($res1 && $res2){
            $res= 'True';
            $sql3 = "DELETE FROM task_code WHERE id='$taskId'";
            if(mysqli_query($con,$sql3)){
                foreach($taskCode as $code){
                    $sql3_1 = "INSERT INTO task_code(id,code) VALUES ('".$taskId."','".$code."')";
                    if(!mysqli_query($con,$sql3_1)){
                        mysqli_query($con,"ROLLBACK");                                      //失败回滚
                        $res= 'False';
                        break;
                    }
                }
            }else{
                mysqli_query($con,"ROLLBACK");                                      //失败回滚
                $res= 'False';
            }

            $sql4 = "DELETE FROM task_keyword WHERE id='$taskId'";
            if(mysqli_query($con,$sql4)){
                foreach($keywords as $word){
                    $sql4_1 = "INSERT INTO task_keyword(id,keyword) VALUES ('".$taskId."','".$word."')";
                    if(!mysqli_query($con,$sql4_1)){
                        mysqli_query($con,"ROLLBACK");                                      //失败回滚
                        $res= 'False';
                        break;
                    }
                }
            }else{
                mysqli_query($con,"ROLLBACK");                                      //失败回滚
                $res= 'False';
            }

            if($res == 'True')mysqli_query($con,"COMMIT");                               //成功提交
        }else{
            mysqli_query($con,"ROLLBACK");
            $res= 'False';
        }
        mysqli_query($con,"END"); //关闭事务
        mysqli_query($con,"SET AUTOCOMMIT=1");//设置mysql自动提交
        mysqli_close($con);                   //关闭数据库
        return $res;
    }

    /**
     * 查询任务信息
     */
    public function getTaskInfo($params){
        $pageNum=isset($params["pageNum"])?(int)$params["pageNum"]:0;
        $pageRows=isset($params["pageRows"])?(int)$params["pageRows"]:0;
        if($pageNum>0&&$pageRows>0){
            $startRow=($pageNum-1)*$pageRows;
            $sql="SELECT * FROM user_task order by modifiTime desc limit $startRow,".$pageRows;
            return $this->postTaskInfo($sql);
        }else{
            return "{'result':false,'msg':'请求参数不对'}";
        }

    }


    /******
     ****查询用户任务信息*****
     *
     * ****/
    public function getUserTaskInfo($params){
        $user=isset($params["username"])?$params["username"]:"";
        if($user=="")return false;
        $sql="SELECT * FROM user_task WHERE author='$user' order by modifiTime desc";
        return $this->postTaskInfo($sql);
    }

    /******
     ****查询单个任务信息*****
     * ****/
    public function getTaskInfoById($params){
        $taskId=isset($params["taskId"])?$params["taskId"]:"";
        if($taskId=="")return false;
        $sql="SELECT * FROM user_task WHERE id='$taskId'";
        return $this->postTaskInfo($sql);
    }

    /******
     ****通过关键字查询任务信息*****
     * ****/
    public function getTaskInfoByKeyword($params){
        $keyword=isset($params["keyword"])?$params["keyword"]:"";
        if($keyword==""){
            $sql="SELECT * FROM task_keyword";
        }else{
            $sql="SELECT * FROM task_keyword WHERE keyword LIKE '%$keyword%'";
        }
        $res=$this->msql_select($sql);
        $taskIds=array();
        foreach ($res as $row){
            if(!in_array($row["id"],$taskIds))
                array_push($taskIds,$row["id"]);
        }
        $result="True";
        $tasks=array();
        foreach ($taskIds as $id){
            $res1=$this->msql_select("SELECT * FROM user_task WHERE id='$id'");
            $res2=$this->msql_select("SELECT * FROM task_info WHERE id='$id'");
            $res3=$this->msql_select("SELECT code FROM task_code WHERE id='$id'");
            $res4=$this->msql_select("SELECT keyword FROM task_keyword WHERE id='$id'");
            if(!$res1 || !$res2){
                $result="False";
                break;
            }
            $task=$res1[0];
            $task["code"]=array();
            $task["keyword"]=array();
            foreach ($res3 as $c){
                array_push($task["code"],$c["code"]);
            }
            foreach ($res4 as $k){
                array_push($task["keyword"],urldecode($k["keyword"]));
            }
            $task=array_merge($task,$res2[0]);
            array_push($tasks,$task);
        }
        if($result!="False")$result=json_encode($tasks,JSON_UNESCAPED_UNICODE);
        return str_replace("\\/", "/", $result);
    }

    /****
     * 查询任务信息
     */
    public function postTaskInfo($sql){
        //echo $sql;
        $res=$this->msql_select($sql);
        if($res){
            $json="True";
            foreach ($res as $key =>$row){
                $taskid=$row["id"];
                $taskInfo=$this->msql_select("SELECT * FROM task_info WHERE id='".$taskid."'");
                if(!$taskInfo){
                    $json="{'result':false,'msg':'未搜索到相关任务信息'}";
                    break;
                }
                //$taskInfo[0]["infoLogo"]=str_replace("","",$taskInfo[0]["infoLogo"]);
                $taskInfo[0]["fileUrl"]=stripslashes($taskInfo[0]["fileUrl"]);
                $taskInfo[0]["linkAddress"]=stripslashes($taskInfo[0]["linkAddress"]);
                $res[$key]=array_merge($row,$taskInfo[0]);
                $codes=$this->msql_select("SELECT code FROM task_code WHERE id='".$taskid."'");
                $code=array();
                if($codes){
                    foreach ($codes as $c){
                        array_push($code,$c["code"]);
                    }
                }
                $keywords=$this->msql_select("SELECT keyword FROM task_keyword WHERE id='".$taskid."'");
                $keyword=array();
                if($keywords){
                    foreach ($keywords as $k){
                        array_push($keyword,$k["keyword"]);
                    }
                }
                $res[$key]["code"]=$code;
                $res[$key]["keyword"]=$keyword;
            }
            if($json=="True")$json=json_encode($res,JSON_UNESCAPED_UNICODE);
            return str_replace("\\/", "/", $json);
        }else{
            return "{'result':false,'msg':'未搜索到相关任务'}";
        }
    }

    /**
     * 删除任务
     */
    public function deleteTask($params){
        $taskId=isset($params["taskId"])?$params["taskId"]:"";
        if($taskId=="")return "False";
        $task=$this->msql_select("SELECT * FROM user_task WHERE id='".$taskId."'");
        if(!$task)return "False";

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        mysqli_query($con,'START TRANSACTION');                                         //开启事务
        mysqli_query($con,"SET AUTOCOMMIT=0");                                          //设置mysql不自动提交，需自行用commit语句提交
        $sql1="DELETE FROM user_task WHERE id='".$taskId."'";
        $sql2="DELETE FROM task_info WHERE id='".$taskId."'";
        $sql3="DELETE FROM task_code WHERE id='".$taskId."'";
        $sql4="DELETE FROM task_keyword WHERE id='".$taskId."'";
        $res1 = mysqli_query($con,$sql1);                                                 //向user_task表插入数据
        $res2 = mysqli_query($con,$sql2);                                               //向user_info表插入数据
        $res3 = mysqli_query($con,$sql3);                                                 //向user_task表插入数据
        $res4 = mysqli_query($con,$sql4);                                               //向user_info表插入数据
        if($res1&&$res2&&$res3&&$res4){
            $res="True";
            $fileUrl=$task[0]->fileUrl;
            $file=explode("/img/",$fileUrl);
            $fileArr=explode(".",$file[count($file)-1]);
            if(!$this->deleteFile(array("filename"=>$fileArr[0],"fileType"=>$fileArr[1]))){
                mysqli_query($con,"ROLLBACK");                                      //失败回滚
                $res="False";
            };
            mysqli_query($con,"COMMIT");                                        //成功提交
        }else{
            mysqli_query($con,"ROLLBACK");                                      //失败回滚
            $res="False";
        }

        mysqli_query($con,"END"); //关闭事务
        mysqli_query($con,"SET AUTOCOMMIT=1");//设置mysql自动提交
        mysqli_close($con);                   //关闭数据库
        return $res;
    }

    /***
     * 上传图片
     * @param $params
     * @return string
     */
    public function uploadImg($params){
        $imgtype  = array('gif'=>'gif','png'=>'png','jpg'=>'jpeg','jpeg'=>'jpeg');                                                          //图片类型在传输过程中对应的头信息
        $message  = isset($params['message'])?$params['message']:"";                  //接收以base64编码的图片数据
        $filename = isset($params['filename'])?$params['filename']:"";               //接收文件名称
        $ftype    = isset($params['filetype'])?$params['filetype']:"";                //接收文件类型
        $randNum  = md5(uniqid(rand()));                                               //md5随机数

        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000); //当前时间unix时间戳
        $filename=$filename."_".$msectime."_".$randNum;                                //随机文件名

        $message = base64_decode(substr($message,strlen('data:image/'.$imgtype[strtolower($ftype)].';base64,')));   //首先将头信息去掉，然后解码剩余的base64编码的数据

        $savePath = $this->rootPath."serverFiles/img/";                           //文件保存地址

        $fileRoot=$savePath.$filename.".".$ftype;                                 //保存文件位置

        while(file_exists($fileRoot)){                      //文件名已存在，更改文件名
            $randNum  = md5(uniqid(rand()));
            $filename = $filename."_".$randNum;             //文件名后加上随机数
            $fileRoot = $savePath.$filename.".".$ftype;     //重命名文件名
        }

        $file = fopen($fileRoot,"w");                         //开始写文件
        if(fwrite($file,$message) === false){
            return json_encode(array('code'=>0,'con'=>'failed'),JSON_UNESCAPED_UNICODE);       //写入失败
        }
        $url=str_replace("\\/", "/", $this->filePath.$filename.".".$ftype);    //写入成功
        return json_encode(array('code'=>1,'filename'=>$filename,'filePath'=>$url,'filetype'=>$ftype),JSON_UNESCAPED_UNICODE);
    }

    /**
     * 读取图片信息
     * @return string
     */
    public function readFiles($params){
        $folder   = $this->rootPath.'serverFiles/img';
        $file_arr = array();

        $isUsed=isset($params["isUsed"])?$params["isUsed"]:"";
        if(is_dir($folder)){
            $dirdemo = @opendir($folder);
            if($dirdemo){
                while(($filedemo = readdir($dirdemo))!==false){
                    if ($filedemo!="." && $filedemo!="..") {
                        $isUsage=false;
                        $files=explode('.',$filedemo);
                        if($this->readFileUrl($this->filePath.$filedemo))$isUsage=true;
                        if($isUsed==""){
                            array_push($file_arr,array("filename"=>$files[0],"fileType"=>$files[1],"isUsed"=>$isUsage));
                        }else if($isUsed=="isUsed"&&$isUsage){
                            array_push($file_arr,array("filename"=>$files[0],"fileType"=>$files[1]));
                        }else if($isUsed=="unUsed"&&!$isUsage){
                            array_push($file_arr,array("filename"=>$files[0],"fileType"=>$files[1]));
                        }
                    }
                }
                closedir($dirdemo);
            }
            return json_encode($file_arr,JSON_UNESCAPED_UNICODE);
        }
    }

    /***
     * 清除废弃文件
     */
    public function clearFiles(){
        $files=$this->readFiles(array("isUsed"=>"unUsed"));
        $files=json_decode($files);
        $isCleared=true;
        $info=array("success"=>"文件全部删除成功");
        foreach ($files as $file){
            //echo json_encode($file);
            $path="../serverFiles/img/".$file->filename.".".$file->fileType;

            if(!unlink($path)){
                $isCleared=false;
            };
        }
        if(!$isCleared)$info=array("error"=>"未清洗干净");
        return  json_encode($info,JSON_UNESCAPED_UNICODE);
    }

    /***
     * 查看图片地址是否已存在数据库
     */
    public function readFileUrl($url){
        $sql="SELECT infoLogo FROM task_info WHERE infoLogo='$url'";
        if($this->msql_select($sql)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除本地文件
     * @param $params
     * @return bool
     */
    public function deleteFile($params){
        $filename=isset($params["filename"])?$params["filename"]:"";
        $fileType=isset($params["fileType"])?$params["fileType"]:"";

        if($filename==""||$fileType=="")return false;
        $file="../serverFiles/img/".$filename.".".$fileType;
        if(!unlink($file))return false;
        return true;
    }

    /**
     * 短信验证
     * @param $params
     * @return string
     */
	public function sendMessageVerification($params){
        $apikey = isset($params["apikey"])?$params["apikey"]:""; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $mobile = isset($params["mobile"])?$params["mobile"]:""; //请用自己的手机号代替
        $text="【云片网】您的验证码是";

        if($apikey==""||$mobile=="")return "{'result':false,'msg':'传入参数不对'}";

        $rand=rand(100000,999999);

        $ch = curl_init();

        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // 取得用户信息
        //$json_data = $this->get_user($ch,$apikey);
        //$array = json_decode($json_data,true);
        //echo '<pre>';print_r($array);

        // 发送短信
        $data=array('text'=>$text.$rand,'apikey'=>$apikey,'mobile'=>$mobile);
        $json_data = $this->send($ch,$data);
        return json_encode($json_data,JSON_UNESCAPED_UNICODE);
        //echo '<pre>';print_r($array);

        // 发送模板短信
        // 需要对value进行编码
        /*$data = array('tpl_id' => '1', 'tpl_value' => ('#code#').
            '='.urlencode('1234').
            '&'.urlencode('#company#').
            '='.urlencode('欢乐行'), 'apikey' => $apikey, 'mobile' => $mobile);
        print_r ($data);
        $json_data = $this->tpl_send($ch,$data);
        $array = json_decode($json_data,true);*/
        //echo '<pre>';print_r($array);

        // 发送语音验证码
        /*$data=array('code'=>'9876','apikey'=>$apikey,'mobile'=>$mobile);
        $json_data =$this->voice_send($ch,$data);
        $array = json_decode($json_data,true);*/
        //echo '<pre>';print_r($array);

        // 发送语音通知，务必要报备好模板
        /*
        模板： 课程#name#在#time#开始。 最终发送结果： 课程深度学习在14:00开始
         */

        /*$tpl_id = '123456'; //你自己后台报备的模板id
        $tpl_value = urlencode('#time#').'='.urlencode('1234').
        '&'.urlencode('#name#').'='.urlencode('欢乐行');
        $data=array('tpl_id'=>$tpl_id,'tpl_value'=>$tpl_value,'apikey'=>$apikey,'mobile'=>$mobile);
        $json_data = $this->notify_send($ch,$data);
        $array = json_decode($json_data,true);
        //echo '<pre>';print_r($array);
        curl_close($ch);*/
    }

    /************************************************************************************/
    //获得账户
    function get_user($ch,$apikey){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function tpl_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL,
            'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function voice_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }
    function notify_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }

    function checkErr($result,$error) {
        if($result === false){
            echo 'Curl error: ' . $error;
        }else{
            //echo '操作完成没有任何错误';
        }
    }
}



