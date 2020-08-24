<?php 
require 'admin/config.php';

session_start();
session_destroy();

header('Location: '. RUTA .'/index.php')
?>