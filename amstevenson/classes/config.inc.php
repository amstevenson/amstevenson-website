<?php
ob_start();
session_start();

// FOR DEBUGGING
// error_reporting(E_ALL);
// ini_set('display_errors',1);

// If there isn't an active session associated with a session identifier that
// the user is presenting, then regenerate it just to be sure
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

// Ensure that the session token accommodates checking the cookie to determine if
// the browser is the same or not. It is highly unlikely that the same user will be
// switching between browsers; so we should check for the purpose of preventing session hijacking.
if (isset($_SESSION['HTTP_USER_AGENT']))
{
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
    {
        // Show error - perhaps prompt for password in the future too
        // echo '<script type="text/javascript">alert("Browser error associated with session");</script>';
        exit;
    }
}
else
{
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
}

 // Config array will be passed to the PDO object to create our connection
 $config = array(
  'host'     => 'localhost',
  'username' => '',
  'password'  => '',
  'dbname' => ''
 );

 // Connection to the database
 $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);

 // Set the error mode for the db object
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set timezone
date_default_timezone_set('Europe/London');

// load classes as needed
function __autoload($class){

    $classpath = 'classes/class.'.$class . '.php';
    if ( file_exists($classpath)) {
        require_once($classpath);
    }

    $classpath = '../classes/class.'.$class . '.php';
    if ( file_exists($classpath)) {
        require_once($classpath);
    }

}

include_once('class/user.php');
$user = new User($db);

include_once('class/functions.php');
