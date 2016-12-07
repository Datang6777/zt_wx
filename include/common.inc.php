<?php
//定义全局错误,运行过程中设为0，即不显示所有错误
error_reporting(E_ALL&~E_NOTICE);
include 'config.php';
define('IN_BBS',true);
include 'common.func.php';
date_default_timezone_set(TIMEZONE);
$conn=connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

?>