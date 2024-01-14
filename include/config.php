<?php 

// DB credentials.

define('DB_HOST','localhost');

define('DB_USER','id20308759_pfe_library_db');

define('DB_PASS','Estg-123456-');

define('DB_NAME','id20308759_pfe_library');

// Establish database connection.

try

{

$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}

catch (PDOException $e)

{

exit("Error: " . $e->getMessage());

}

?>