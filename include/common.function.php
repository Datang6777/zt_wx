<?php
function check_input($str)
	{
		$str = str_replace("\r\n","",$str);
    	$str = str_replace("\n","",$str);
    	$str = str_replace("\r","",$str);
    	$str = str_replace("'","&#39",$str);
		$str = str_replace("\"","”",$str);
    	$str = str_replace("<","＜",$str);
    	$str = str_replace(">","＞",$str);
		$str = str_replace("php","",$str);
		//$str = str_replace("?","？",$str);
		$str = str_replace("eval","",$str);
		$str = str_replace("%","％",$str);
		$str = str_replace("$","",$str);
		$str = str_replace("script"," ",$str);
		//$str = str_replace("="," ",$str);
		$str = str_replace("and"," ",$str);
		$str = str_replace("select"," ",$str); 
		$str = str_replace("delete"," ",$str);
		$str = str_replace("update"," ",$str);
    	return  $str;
	}
 function get_client_ip() 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
			foreach ($matches[0] AS $xip) {
				if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
					$ip = $xip;
					break;
				}
			}
		}
		if(!validateIP($ip))
		{
			$ip = "Unknown";
		}
		return $ip;
	}


	function validateStr($pStr)
	{
	   if(ereg('[^a-zA-Z0-9_-]', $pStr))
	   {
		 return false;
	   } 
	   else 
	   {
		 return true;
	   }
	}
	
	function validateIP($pInt)
	{
	   if(ereg('[^0-9.]', $pInt))
	   {
		 return false;
	   } 
	   else 
	   {
		 return true;
	   }
	}
	
	function IP_str()
	{
		if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
		{
			$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
		}
		elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
		{
			$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
		}
		elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])
		{
			$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
		{
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("HTTP_CLIENT_IP"))
		{
			$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("REMOTE_ADDR"))
		{
			$ip = getenv("REMOTE_ADDR");
		}
		else
		{
			$ip = "Unknown";
		}
		$IPAdress        =  $ip;

		if(!validateIP($IPAdress))
		{
			$IPAdress = "127.0.0.1";
		}
		return $IPAdress;
	}

?>