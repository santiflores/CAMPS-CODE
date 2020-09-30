<?php
session_start();
require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);

if (!$conexion) {
    header('Location: error.php');
};


require 'views/index.view.php';
?>
