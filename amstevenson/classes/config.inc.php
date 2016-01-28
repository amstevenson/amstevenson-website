<?php
 # Config array will be passed to the PDO object to create our connection
 $config = array(
  'host'     => 'localhost',
  'username' => 'root',
  'password'  => '',
  'dbname' => ''
 );

 # Connection to the database
 $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);

 # Set the error mode for the db object
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

