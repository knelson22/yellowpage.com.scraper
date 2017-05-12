<?php
include "sql.php";
include 'url.php';
// include 'yp_query.php'; // does initial query- page amount return
include 'curl.php';
include 'yp_page.php';

error_reporting(1);  
$currpage = 1;
$index;

// $url[0] = "http://www.yellowpages.com/urbana-il/leather-goods-not-elsewhere-classified";

if (! $url)
{
    $u = new url();
    $url = $u->url;
    $query_index = $u->index;
}

for ($i = 0; $i < count($url); $i ++)
{
    
    $firstqry = new yp_page($url[$i]);
    
    if ($firstqry->checkforerr())
    {
        // good
        $firstqry->getpages();
        $total = $firstqry->total;
        $pages = $firstqry->pages;
        updattotal($total, $query_index[$i]);
        $firstqry->parse($query_index[$i]);
        
        for ($j = 2; $j <= $pages; $j ++)
        {
            $curqry = new yp_page($url[$i] . "?page=$j");
            
            if ($curqry->checkforerr())
            
            {
                
                $curqry->parse($query_index[$i]);
            }
            else
            {
                
                no_res($query_index[$i]);
                break;
            }
        }
        
        done($query_index[$i]);
    }
    else
    {
        
        no_res($query_index[$i]);
    }
}

mysql_close($conn);
curl_close($ch);

