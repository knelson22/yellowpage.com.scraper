<?php

class yp_page
{

    function parse($query_index)
    {
        $base = '  insert ignore into results(name, phone, address, town, state, zip, categories, yurl, website, query) values  ';
        $domdoc;
        global $conn;
        $data;
        $url;
        $qt;
        $ch;
        $pagenum;
        $currpage;
        
        $name = array();
        $url;
        
        $phone = array();
        $all_cat = array();
        $website = array();
        $c = array();
        $st = array();
        $town = array();
        $state = array();
        $z = array();
        $internal_site = array();
        $sql = $base;
        $total;
        $pages;
        $tries = 0;
        $q = "\""; // QUOTE################
        
        $divs = $this->divs;
        
        // name, phone, address, city, state, zip, categories, yurl, website
        // name, phone, $st, $town, state, $z, $c, $internal_site, $website
        global $domdoc;
        $divslen;
        $divslen = $divs->length;
        
        $count = - 1;

        $tries = 0;
        for ($i = 0; $i < $divslen; $i ++)
        {
        
            if ($divs->item($i)->attributes->getNamedItem('class')->nodeValue == 'info' &&
        
                is_numeric($divs->item($i)->firstChild->nodeValue[0]))
            {
        
//                 <h3 class="n">4.&nbsp;
                $count ++;
        
                ;
                ;
        
                $child = $divs->item($i);
        
                // var_dump($child);
        
                $a = $child->getElementsByTagName('a');
                $div = $child->getElementsByTagName('div');
                $span = $child->getElementsByTagName('span');
        
                // a
                for ($j = 0; $j < $a->length; $j ++)
                {
        
                    if ($a->item($j)->attributes->getNamedItem('itemprop')->nodeValue == 'name' && $a->item($j)->nodeValue != null)
        
                    {
                        $name[$count] = $a->item($j)->nodeValue;
                        ;
                        ;
                        $internal_site[$count] = $a->item($j)->attributes->getNamedItem('href')->nodeValue;
                    }
        
                    // missing
        
                    if ($a->item($j)->attributes->getNamedItem('class')->nodeValue == 'track-visit-website')
                    {
        
                        $website[$count] = $a->item($j)->attributes->getNamedItem('href')->nodeValue;
                    }
                }
        
                // div
                for ($j = 0; $j < $div->length; $j ++)
                {
        
                    if ($div->item($j)->attributes->getNamedItem('itemprop')->nodeValue == 'telephone')
                    {
                        $phone[$count] = $div->item($j)->nodeValue;
                    }
        
                    if ($div->item($j)->attributes->getNamedItem('class')->nodeValue == 'categories')
                    {
        
                        $innner = $div->item($j)->getElementsByTagName('a');
        
                        for ($k = 0; $k < $a->length; $k ++)
                        {
        
                            if ($innner->item($k)->nodeValue != null)
        
                                $c[$count][$k] = $innner->item($k)->nodeValue;
                        }
                    }
                }
        
                // sp
        
                for ($j = 0; $j < $span->length; $j ++)
                {
        
                    if ($span->item($j)->attributes->getNamedItem('itemprop')->nodeValue == 'streetAddress')
                    {
                        $st[$count] = $span->item($j)->nodeValue;
                    }
        
                    if ($span->item($j)->attributes->getNamedItem('class')->nodeValue == 'locality')
                    {
                        $town[$count] = rtrim($span->item($j)->nodeValue, ',');
                    }
        
                    if ($span->item($j)->attributes->getNamedItem('itemprop')->nodeValue == 'addressRegion')
                        $state[$count] = $span->item($j)->nodeValue;
        
                        if ($span->item($j)->attributes->getNamedItem('itemprop')->nodeValue == 'postalCode')
                        {
                            $z[$count] = $span->item($j)->nodeValue;
                        }
        
                        ;
                        // . "\n"
        
                        // ;
                }
            }
        }
        
        $sql = $base;
        for ($i = 0; $i <= $count; $i ++)
        {
        
            $cat = '';
            foreach ($c[$i] as $cc)
            {
                $cat .= $cc . " /";
                array_push($all_cat, $cc);
                ;
                ;
                 
        
                ;
                ;
            }
            //echo $cat . "\n";
        
            $qt = "$q, $q";
            $sql .= "($q" . $name[$i] . $qt . $phone[$i] . $qt . $st[$i] . $qt . $town[$i] . $qt . $state[$i] . $qt . $z[$i] . $qt .
            $cat .  
            $qt . $internal_site[$i] . $qt . $website[$i] . $qt . $query_index . "$q  ),";
        

        }
        
        $all_cat= array_unique($all_cat);
        
        
        $sql = rtrim($sql, ",") . ";";
        //echo $sql;
        if ($conn->query($sql) === TRUE)
        {
            echo "New record created successfully";
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        //             $currpage ++;
        
        //             $url = strstr($url, "page=", true);
        //             $url .= "page=$currpage";
        //             // echo $url;
        //             curl_setopt($ch, CURLOPT_URL, $url);
        //             $data = curl_exec($ch);
        //             $domdoc = new DOMDocument();
        //             $domdoc->loadHTML($data);
        
        //             $divs = $domdoc->getElementsByTagName('div');
        //             $divslen = $divs->length;
        
        
        
        
        
        //                 sleep($tries);
        //                 $tries ++;
        //                 if ($tries == 13)
            //                     die();
        
            //                 $data = curl_exec($ch);
            //                 $domdoc = new DOMDocument();
            //                 $domdoc->loadHTML($data);
            //                 $divs = $domdoc->getElementsByTagName('div');
            //                 $divslen = $divs->length;
              
        
    }

    function yp_page($url)
    {
        $this->url = $url;
        global $ch;
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        global $domdoc;
        $domdoc = new DOMDocument();
        $domdoc->loadHTML($data);
        $this->divs = $domdoc->getElementsByTagName('div');
        $data = 0;
    }

    function checkforerr()
    {
        global $domdoc;
        if ($domdoc->getElementById('no-results-main'))
            return false;
        else
            return true;
    }



    function getpages()
    {
        
        $divslen = $this->divs->length;
        

        
       
            for ($i = $divslen - 1; $i > 0; $i --)
            {
                
                if ($this->divs->item($i)->attributes->getNamedItem('class')->nodeValue == 'pagination')
                {
                    
                    $total = strstr($this->divs->item($i)->nodeValue, "of");
                    
                    
                    
                    ;
                    ;
          
                    $total = strstr($total, 'results', true);
                   
                           echo $total;   
                    
                    
                    
                    
                    
                    $total = filter_var($total, FILTER_SANITIZE_NUMBER_INT);
                    
                    // echo $total;
                    // die ();
                }
            }
            
            $pages = ceil($total / 30);
           
            
            
            
            
            $this->total = $total;
            $this->pages = $pages;

            
            
        }
        // echo $pages;
    
    
    
}