 <!DOCTYPE html>
<html lang="es" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Inicio - CAMPS</title>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
		<link rel="shortcut icon" type="image.png" href="<?php echo(RUTA);?>/images/favicon_CAMPS.png">
		<script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
	</head>
	<body>
	<?php require 'header.php'?>
                <div class="titulo_medicos">
                    <p>Cartilla de medicos</p>
                </div>
	<div class="body-wrap">
            <div class="busqueda">
                <div class="busqueda--header">
                    <b>Opciones de Busqueda</b>
                </div>
                <form action="<?php echo($_SERVER['PHP_SELF'])?>" class="busqueda--inner" id="filtros">
                    <div class="combo-busqueda">
                        <b>Buscar medicos</b>
                        <input type="text" class="input-text" name="busqueda" placeholder="Buscar..." value="<?php if (!empty($_GET['busqueda'])){echo($_GET['busqueda']);}?>">
                        <span class="border-button" id="filtros-submit">Buscar</span>
                    </div>
                    <div class="filtros">
                        <b>Filtros</b>
                        <div class="filtros--item">
                            <b>Especialidad</b>
                            <select name="especialidad" class="input-select" id="filtro-select">
                                <option disabled="true" selected="true">Elegí una especialidad</option>
                                <option value="" class="filtro-option" id="option">Todas las especialidades</option>
                                <?php
                                if (isset($_GET['especialidad']) && !empty($_GET['especialidad'])) {
                                    echo('<option selected="true" class="filtro-option">'.$_GET['especialidad'].'</option>');
                                } else {
                                    echo('
                                    <option disabled="true" selected="true">Elegí una especialidad</option>');
                                    
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
                            <div class="filtro-radio">
                                <input type="radio" name="sucursal" id="alderetes" value="alderetes" <?php if (!empty($_GET['sucursal'])){
                                    if ($_GET['sucursal']=='alderetes') {
                                        echo('checked');
                                    }
                                    }?>>
                                <label for="alderetes">Alderetes</label>
                            </div>
                            <div class="filtro-radio">
                                <input type="radio" name="sucursal" id="BdRS" value="BdRS" disabled <?php if (!empty($_GET['sucursal'])){
                                    if ($_GET['sucursal']=='BdRS') {
                                        echo('checked');
                                    }
                                    }?>>
                                <label for="BdRS">Banda del Rio Salí (próximamente)</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="content-wrapper">
		<section class="wrapper_especialidades">
		
			<?php mostrarEspMedicos($session_hash, $especialidades, $conexion);?>

		</section>
		<?php require 'views/footer.php';?>
		<script src="<?php echo RUTA?>/js/scripts.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
</html>