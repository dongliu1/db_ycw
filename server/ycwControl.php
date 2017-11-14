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
    public function __construct__()
    {                                    //初始化地址信息
        $this->host="localhost";
        $this->dbuser="root";
        $this->dbpsw="";
        $this->database="db_ycw";
        $this->port="80";
    }

}