<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
function IsNullOrEmptyString($question){
	return (!isset($question) || trim($question)==='');
}
  
 
function valid_url($url)
{
    $pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
    if (!preg_match($pattern, $url))
    {
        return FALSE;
    }

    return TRUE;
}

function clean_fordb($stringdata)
{
	$stringdata = htmlentities($stringdata);
	$stringdata = str_ireplace(array("&lt;br&gt;","&lt;br/&gt;","&lt;br /&gt;","&amp;lt;br&amp;gt;","&amp;lt;br/&amp;gt;","&amp;lt;br /&amp;gt;"), "<br />", $stringdata);
	return $stringdata;
}


// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}