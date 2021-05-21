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
        <div class="separador">
            <a href="cartilla.php" class="flecha-volver">
                <img src="../images/flecha.svg">
            </a>
            <b>Agenda de Dr/a: Santiago Flores</b>
        </div>
        <div class="body-wrap">
            <div class="busqueda">
                <div class="busqueda--header">
                    <b>Opciones de Busqueda</b>
                </div>
                <form action="<?php echo($_SERVER['PHP_SELF'])?>" class="busqueda--inner" id="filtros">
                    <div class="combo-busqueda">
                        <b>Buscar medicos</b>
                        <input type="text" class="input-text filtro-input" name="busqueda" placeholder="Buscar..." value="<?php if (!empty($_GET['busqueda'])){echo($_GET['busqueda']);}?>">
                        <span class="border-button" id="busqueda-submit">Buscar</span>
                    </div>
                </form>
            </div>
            <div class="content-wrapper">
                <div class="agenda">
                    <div class="agenda-time-tags">
                        <span class="time-tag">8:00</span>
                        <span class="time-tag">9:00</span>
                        <span class="time-tag">10:00</span>
                        <span class="time-tag">11:00</span>
                        <span class="time-tag">12:00</span>
                        <span class="time-tag">13:00</span>
                        <span class="time-tag">17:00</span>
                        <span class="time-tag">18:00</span>
                        <span class="time-tag">19:00</span>
                        <span class="time-tag">20:00</span>
                        <span class="time-tag">21:00</span>
                    </div>
                    <div class="agenda-column">
                        <div class="agenda--header">
                            <span>
                                Jueves
                            </span>
                            <span>
                                20
                            </span>
                            <span>
                                Mayo
                            </span>
                        </div>
                        <div class="hour-block"></div>
                        <span class="hour-block block-quarters">
                            <div class="agenda-appointment">Carlos Martin - 9:00</div>
                            <div class=""></div>
                            <div class="agenda-appointment">Carlos Martin - 9:30</div>
                            <div class="agenda-appointment">Carlos Martin - 9:45</div>
                        </span>
                        <span class="hour-block"></span>
                        <span class="hour-block"></span>
                        <span class="hour-block half">
                            <div class="agenda-appointment">Carlos Martin - 12:00</div>
                            <div class="agenda-appointment">Carlos Martin - 12:00</div>
                        </span>
                        <span class="hour-block agenda-break"></span>
                        <span class="hour-block"></span>
                        <span class="hour-block"></span>
                        <span class="hour-block"></span>
                        <span class="hour-block"></span>
                    </div>
                    <div class="agenda-column">
                        <div class="agenda--header">
                            <span>
                                Viernes
                            </span>
                            <span>
                                21
                            </span>
                            <span>
                                Mayo
                            </span>
                        </div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block agenda-break"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                    </div>
                    <div class="agenda-column">
                        <div class="agenda--header">
                            <span>
                                Lunes
                            </span>
                            <span>
                                24
                            </span>
                            <span>
                                Mayo
                            </span>
                        </div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block agenda-break"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                    </div>
                    <div class="agenda-column">
                        <div class="agenda--header">
                            <span>
                                Martes
                            </span>
                            <span>
                                25
                            </span>
                            <span>
                                Mayo
                            </span>
                        </div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block agenda-break"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                    </div>
                    <div class="agenda-column">
                        <div class="agenda--header">
                            <span>
                                Miercoles
                            </span>
                            <span>
                                26
                            </span>
                            <span>
                                Mayo
                            </span>
                        </div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block agenda-break"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                        <div class="hour-block"></div>
                    </div>
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
