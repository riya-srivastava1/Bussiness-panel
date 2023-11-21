<?php

function cdn($url = null)
{
    $url = (string) $url;
    if(empty($url))
    {
        throw new Exception('URL missing');
    }

    $pattern = '|^http[s]{0,1}://|i';        
    if(preg_match($pattern, $url))
    {
        throw new Exception('Invalid URL. ' .
            'Use: /image.jpeg instead of full URI: ' .
            'https://zoycdn.zoylee.com/image.jpeg.'
        );
    }
        
    $pattern = '|^/|';        
    if(!preg_match($pattern, $url))
    {
        $url = '/' . $url;
    }

    if(!Config::get('app.cdn_enabled'))
    {
        return $url;
    }
    else
    {
        return Config::get('app.cdn_protocol') . '://' . Config::get('app.cdn_domain') . $url;
    }    
}