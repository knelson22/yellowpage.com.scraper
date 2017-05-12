<?php




    $servername = 'localhost';


$username = "karlscav";
$password = "";
$dbname = "karlscav_yp";




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

query("set time_zone = '-6:00'");
;
;

/*
 * $sql = "SELECT * from zip";
 * $result = $conn->query($sql);
 *
 * ;
 *
 */
// var_dump($_SERVER);

;
;
;

function query($sql)
{
    global $conn;
    if ($conn->query($sql) === TRUE)
    {
        //echo "New record created successfully";
    }
    else
    {
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    ;
}

function updattotal($n, $i)
{
    $sql = "UPDATE `query`  set `total` = " . $n . " where `in` = " . $i;
    query($sql);
    
    ;
}

function done($i)
{
    $sql = "UPDATE `query`  set `done` = 1  where `in` = " . $i;
    query($sql);
    
    ;
}

function no_res($i)
{
    $sql = "UPDATE `query`  set `done` = 1,  `reason`   ='no-results-main' where `in` = " . $i;
    query($sql);
    
    ;
}

?> 
