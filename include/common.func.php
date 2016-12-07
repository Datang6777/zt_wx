<?php
defined('IN_BBS') or die('访问失败');
function connect($host,$name,$pwd,$db){
	$conn=mysql_connect($host,$name,$pwd);
	if(mysql_errno()){
		exit(mysql_error());
	}
	if('5.0'>mysql_get_server_info()){
		exit('您的数据库版本过低');
	}
	mysql_select_db($db);
	
	return $conn;
}

function close($conn){
	mysql_close($conn);
}
?>