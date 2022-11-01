<?php

define("DB_TYPE", "mysql");
define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DB_NAME", "test");

try{
	$con = new PDO(DB_TYPE.":host=".HOSTNAME.";dbname=".DB_NAME, USERNAME, PASSWORD);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
	echo "Connection failed: " . $e->getMessage();
}
?>