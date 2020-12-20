<?php

function OpenCon()
 {
 $dbhost = "sql9.freemysqlhosting.net";
 $dbuser = "sql9383047";
 $dbpass = "vyJ66LvAqb";
 $db = "sql9383047";


 $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);

 
 return $conn;
}
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>