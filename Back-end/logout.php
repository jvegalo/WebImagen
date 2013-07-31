<?php
if(!session_start()) session_start();
$order = $_REQUEST["message"];
//destroy session
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);

?>