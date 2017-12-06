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
    public $dbpsw="usbw";               //数据库密码
    public $database="db_ycw";          //数据库名称
    public $port="80";                  //端口号
    public $filename="../serverFiles/files/db_ycw.sql";      //sql文件

    public $filePath="";                //文件ip地址
    public $rootURL="";                 //站点ip地址
    public $rootPath="";                //服务器站点根目录

    public function __construct()
    {                                    //初始化地址信息
        $this->host="182.61.38.236";
        $this->dbuser="root";
        $this->dbpsw="guo2013kong";
        $this->database="db_ycw";
        $this->port="80";

        $this->init_filePath();         //初始化文件地址
    }

    /***
     * 查询操作
     * @sql:sql查询语句
     */
    public function msql_select($sql){
        if(!is_string($sql))return false;

        $con=mysqli_connect($this->host,$this->dbuser,$this->dbpsw,$this->database);    //连接数据库
        if (!$con)die('Could not connect: ' . mysqli_error($con));      //连接失败
        mysqli_set_charset($con,'utf8');                                //设置中文编码
        $result = mysqli_query($con,$sql);                              //查询结果
        $rows=mysqli_num_rows($result);                                 //结果有多少行
        //echo $rows;
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
        mysqli_set_charset($con,'utf8');                                                //设置中文编码
        $result = mysqli_query($con,$sql);                              //查询结果
        mysqli_close($con);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /***
     * 文件目录
     */
    public function init_filePath(){
        $PHP_SELF       =  $_SERVER['PHP_SELF']?$_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $url            =  'http://'.$_SERVER['HTTP_HOST'].substr($PHP_SELF,0,strrpos($PHP_SELF,'/')+1);  //当前文件所在目录链接
        $urlArr         =  explode('db_ycw/',$url);
        $this->rootURL  =  $urlArr[0]."db_ycw/";                                //站点ip地址
        $this->filePath =  $this->rootURL."serverFiles/img/";                   //文件ip地址
        $this->rootPath =  $_SERVER["DOCUMENT_ROOT"]."/db_ycw/";                //服务器站点目录
    }
}