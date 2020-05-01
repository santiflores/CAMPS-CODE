<?php session_start();
  require 'config.php';
  require '../functions.php';

  require '../views/login.view.php';
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = limpiarDatos($_POST ['usuario']);
    $pass = limpiarDatos($_POST ['contraseña']);
    
    if  ($user == $admin['username'] && $pass == $admin['password']) { 
      $_SESSION['admin'] = $admin['username'];
      header('location: ' . RUTA . '/admin/administracion.php');
    }
  }
?>