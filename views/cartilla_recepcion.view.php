<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CAMPS - Recepción</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php require 'header.php'; ?>
        <div class="body-wrap">
            <div class="busqueda">
                <div class="busqueda--header">
                    <b>Opciones de Busqueda</b>
                </div>
                <form action="<?php echo($_SERVER['PHP_SELF'])?>" class="busqueda--inner">
                    <div class="combo-busqueda">
                        <b>Buscar medicos</b>
                        <input type="text" class="input-text" name="busqueda" placeholder="Buscar...">
                        <input type="submit" value="Buscar" class="border-button">
                    </div>
                    <div class="filtros">
                        <b>Filtros</b>
                        <div class="filtros--item">
                            <b>Especialidad</b>
                            <select name="especialidad" class="input-select">
                                <option disabled="true" selected="true">Elegí una especialidad</option>
                                <option value="">Todas las especialidades</option>
                                <?php
                                if (isset($_GET['especialidad']) && $_GET['especialidad']) {
                                    echo('<option selected="true">'.$_GET['especialidad'].'</option>                                    ');
                                }
                                $especialidades = obtenerEspecialidades($conexion);
                                foreach ($especialidades as $especialidad) {
                                    $especialidad = $especialidad[1];
                                    echo('<option value="'. $especialidad .'">'. $especialidad .'</option>');
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filtros--item">
                            <b>Centros medicos</b>
                            <div>
                                <input type="radio" name="sucursal" id="alderetes" value="alderetes">
                                <label for="alderetes">Alderetes</label>
                            </div>
                            <div>
                                <input type="radio" name="sucursal" id="BdRS" value="BdRS" disabled>
                                <label for="BdRS">Banda del Rio Salí (próximamente)</label>
                            </div>
                        </div>
                        <input type="submit" value="Aplicar" class="border-button">
                    </div>
                </form>
            </div>
            <div class="content-wrapper">
                <div class="titulo_medicos">
                    <p>Cartilla de medicos</p>
                </div>
                <div class="lista-header">
                    <span>
                        Nombre y apellido
                    </span><span>
                        Especialidad
                    </span><span>
                        Horario de atencion
                    </span>
                </div>
                <div class="lista-wrapper">
                    <?php mostrarMedicos($medicos)?> 
                </div>
            </div>
        </div>
		<?php require 'footer.php';?>
		<script src="<?php echo(RUTA)?>/js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>
