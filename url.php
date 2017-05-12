<?php

class url
{

    public $url = array();

    public $index = array();

    function url()
    {
        global $conn;
        // var_dump($conn);
        $result = $conn->query("select base, `city-st`, searchon, `in` from query where done = 0  limit 10");
        
        while ($r = $result->fetch_row())
        {
            $num = count($this->url);
            $this->url[$num] = $r[0] . $r[1] . $r[2];
            $this->index[$num] = $r[3];
        }
        
        $result->close();
    }
}