<?php
    require 'admin/config.php';
    require 'functions.php';
    
    $conexion = conexion($bd_config);
    if (!$conexion) {
        header('location: error.php');
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['busqueda'])) {
        $busqueda = limpiarDatos($_GET['busqueda']);
        
        $statement = $conexion->prepare(
            'SELECT * FROM medicos WHERE nombre LIKE :busqueda or especialidad LIKE :busqueda'
        );
        $statement->excecute(array(':busqueda' => "%$busqueda%"));
        $resultados = $statement->fetchAll();
        
        if (empty($resultados)) {
            $titulo = 'No se encontraron medicos con el resultado: ' . $busqueda;
        } else {
            $titulo = 'Resultados de la busqueda: ' . $busqueda; 
        }
    }
    
    $especialidades = obtenerEspecialidades($conexion);
    require 'views/medicos.view.php';
    
?>