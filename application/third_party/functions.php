<?php
function pr($arr,$e=1)
{
	if(is_array($arr))
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";		
	}
	else
	{
		echo "<br>Not an array...<br>";
		echo "<pre>";
		var_dump($arr);
		echo "</pre>";
	}
	if($e==1)
	{
		exit();
	}
	else
	{
		echo "<br>";
	}
		
}
	
//Create array from xml data 
function xml2array($domnode)
{
    $nodearray = array();
    $domnode = $domnode->firstChild;
    while (!is_null($domnode))
    {
        $currentnode = $domnode->nodeName;
        switch ($domnode->nodeType)
        {
            case XML_TEXT_NODE:
                if(!(trim($domnode->nodeValue) == "")) $nodearray['cdata'] = $domnode->nodeValue;
            break;
            case XML_ELEMENT_NODE:
                if ($domnode->hasAttributes() )
                {
                    $elementarray = array();
                    $attributes = $domnode->attributes;
                    foreach ($attributes as $index => $domobj)
                    {
                        $elementarray[$domobj->name] = $domobj->value;
                    }
                }
            break;
        }
        if ( $domnode->hasChildNodes() )
        {
            $nodearray[$currentnode][] = xml2array($domnode);
            if (isset($elementarray))
            {
                $currnodeindex = count($nodearray[$currentnode]) - 1;
                $nodearray[$currentnode][$currnodeindex]['@'] = $elementarray;
            }
        } else {
            if (isset($elementarray) && $domnode->nodeType != XML_TEXT_NODE)
            {
                $nodearray[$currentnode]['@'] = $elementarray;
            }
        }
        $domnode = $domnode->nextSibling;
    }
    return $nodearray;
}
function mysql2indian($dt, $format = "d-m-Y")
{
	if($dt == '')
	{
		return $dt;
	}
	$dt1 =  date($format,strtotime($dt));
	return $dt1;
}
function indian2mysql($dt, $format = "Y-m-d")
{
	if($dt == '')
	{
		return $dt;
	}
	$dt1 =  date($format,strtotime($dt));
	return $dt1;
}
  function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) 
	{
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) 
	{
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('Year','Month','Day','Hour','Minute','Second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) 
	{
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) 
	  {
		$time1 = $ttime;
		$diffs[$interval]++;
		// Create new temp time from time1 and interval
		$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) 
	{
      // Break if we have needed precission
      if ($count >= $precision) 
	  {
		break;
      }
      // Add value and interval 
      // if value is bigger than 0
		// Add s if value is not 1
		if ($value != 1) 
		{
		  $interval .= "s";
		}
		// Add value and interval to times array
		$times[] = $interval . ":&nbsp;" . $value."";
		$count++;
    }
 
    // Return string with times
    return implode(", ", $times);
  }
function getTimespan($start,$end=null)
{
 if ($end == null) { $end = time(); }
 $seconds = $end - $start;
 $days = floor($seconds/60/60/24);  
 $hours = $seconds/60/60%24;  
 $mins = $seconds/60%60;  
 $secs = $seconds%60;
   
 $duration='';  
 if($days>0)
 {
 	$duration .= "$days days ";
 }
 else
 {	
	 if($hours>0)
	 {
	 	$duration .= "$hours hours ";
	 }
	 else
	 {
	 	if($mins>0)
	 	{
	 		$duration .= "$mins minutes ";
		}
		else
		{
			if($secs>0) $duration .= "$secs seconds ";
		}
	 }
 }
 $duration = trim($duration);  
 if($duration==null) $duration = '0 seconds';  
 $duration	.=	" ago";
 return $duration;
}
function getDecimalFromIP($ip=0)
{
	$decimal	=	0;
	if($ip == "")
		return 0;
	$ip_str	=	explode('.',$ip);
	if(is_array($ip_str) && count($ip_str) >0 && count($ip_str) <= 4)
	{
		$decimal	=	16777216*$ip_str[0] + 65536*$ip_str[1] + 256*$ip_str[2] + $ip_str[3];
	}
	return $decimal;
}
function isLoggedIn(){
	$CI =& get_instance();
	$FRONT_USER_SESSION_ID = intval($CI->session->userdata('front_user_id'));
	if($FRONT_USER_SESSION_ID > 0 && $CI->session->userdata('front_is_logged_in') === true)
		return true;
	else
		return false;
}

if ( ! function_exists('file_upload_base_url'))
{
	function file_upload_base_url()
	{
		$CI =& get_instance();
		return $CI->config->slash_item('file_upload_base_url');
	}
}

if ( ! function_exists('file_upload_s3_path'))
{
	function file_upload_s3_path()
	{
		$CI =& get_instance();
		return $CI->config->slash_item('file_upload_s3_path');
	}
}
if ( ! function_exists('maac_base_url'))
{
	function maac_base_url()
	{
		$CI =& get_instance();
		return $CI->config->slash_item('maac_base_url');
	}
}
?>