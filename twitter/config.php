<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','coderslab');
define('DB_DB','twitter');


$conn = new PDO('mysql:host='.DB_HOST.';dbname='. DB_DB, DB_USER, DB_PASS);
