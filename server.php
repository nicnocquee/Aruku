<?php

// fetch_page function is from http://nashruddin.com/fetching-a-web-page-from-php-code.html

function fetch_page($url)
{
    /* get hostname and path */
    $host = parse_url($url, PHP_URL_HOST);
    $path = parse_url($url, PHP_URL_PATH);
 
    if (empty($path)) {
        $path = "/";
    }
   
    /* Build HTTP 1.0 request header. Defined in RFC 1945 */
    $headers = "GET $path HTTP/1.0\r\n"
             . "User-Agent: myHttpTool/1.0\r\n\r\n";
   
    /* open socket connection to remote host on port 80 */
    $fp = fsockopen($host, 80, $errno, $errmsg, 30);
   
    if (!$fp) {
        /* ...some error handling... */
        return false;
    }
   
    /* send request headers */
    fwrite($fp, $headers);
   
    /* read response */
    while(!feof($fp)) {
        $resp .= fgets($fp, 4096);
    }
    fclose($fp);
   
    /* separate header and body */
    $neck = strpos($resp, "\r\n\r\n");
    $head = substr($resp, 0, $neck);
    $body = substr($resp, $neck+4);
   
    /* omit parsing response headers */
   
    /* return page contents */
    return($body);
}

echo json_encode(array('content' => fetch_page('http://eow.alc.co.jp/'.$_GET['string_to_translate'].'/UTF-8/')));
?>