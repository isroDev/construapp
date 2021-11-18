<?php

$response;
$server                 =       "localhost";
$db                     =       "const_db_3";
$username               =       "root";
$password               =       "9836";




try
{
    if ($db_conn = mysqli_connect($server, $username, $password, $db))
    {
        mysqli_set_charset($db_conn, 'utf8');
       
    }
    else
    {
        throw new Exception('Unable to connect');
    }
}
catch(Exception $e)
{
    $response["db_connect"] = $e->getMessage();
}
?>