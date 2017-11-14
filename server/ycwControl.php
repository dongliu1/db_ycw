<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 20:53
 */

class ycwControl
{

    public $host="localhost";           //默认地址
    public $dbuser="root";              //数据库账号
    public $dbpsw="";                   //数据库密码
    public $database="db_ycw";          //数据库名称
    public $port="80";                  //端口号
    public $filename="db_ycw.sql";      //sql文件

    public function __construct__()
    {                                    //初始化地址信息
        $this->host="localhost";
        $this->dbuser="root";
        $this->dbpsw="";
        $this->database="db_ycw";
        $this->port="80";
    }

    /***
     * 查询操作
     * @sql:sql查询语句
     */
    public function msql_select($sql){
        if(!is_string($sql))return false;

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        $result = mysqli_query($con,$sql);                              //查询结果
        $rows=mysqli_num_rows($result);                                 //结果有多少行
        if($rows){
            $infos = array();
            while ($rows=mysqli_fetch_array($result)){
                $count=count($rows);//不能在循环语句中，由于每次删除 row数组长度都减小
                for($i=0;$i<$count;$i++){
                    unset($rows[$i]);//删除冗余数据
                }
                array_push($infos,$rows);
            }
            mysqli_close($con);
            return $infos;
        }else{
            mysqli_close($con);
            return false;
        }
    }

    /***
     * 增删改
     * @sql:sql查询语句
     */
    public function msql_execute($sql){
        if(!is_string($sql))return false;

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        $result = mysqli_query($con,$sql);                              //查询结果
        mysqli_close($con);
        if($result){
            return true;
        }else{
            return false;
        }
    }
}