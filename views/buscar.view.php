<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - CAMPS</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lobster&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
    <script src="<?php echo RUTA?>/js/scripts.js"></script>
    <script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <script>
    </script>
    <?php require 'header.php'?>
    <div id="wrapper_turno_padre">
      <div class="wrapper_turno">
        <div class="form_title">
          <h3><?php ?></h3>
          <button type="button" onclick="cerrar_turno()" name="button" class="cerrar_turno">
            <i class="fas fa-times fa-2x"></i>
          </button>
        </div>
        <div class="wrapper_formulario">
          <form class="" action="<?php echo htmlspecialchars ($_SERVER['PHP_SELF']); ?>" method="post">
            <h6>Nombre y Apellido:</h6>
            <input type="text" name="nombre" placeholder="Nombre" value="">
            <input type="text" name="Apellido" placeholder="Apellido" value="">
            <h6>DNI:</h6>
            <input type="text" name="dni" value="">
            <h6>Numero de telefono:</h6>
            <input type="text" name="telefono" value="">
            <h6>Fecha de nacimiento:</h6>
            <input type="date" name="fecha_de_nacimiento" value="">
            <h6 class="fecha_del_turno">Fecha del Turno</h6>
            <input type="datetime-local" name="" value="" class="input_calendario">

            <input type="submit" name="submit" class="boton_reservar" value="Reservar Turno">
          </form>
        </div>
        <div class="wrapper_calendario">
          <div class="calendario">

          </div>
        </div>
      </div>
    </div>
  <section class="wrapper_especialidades">
    <div class="titulo_medicos">
      <h2>Saca tu turno</h2>
      <form action="buscar.php" method="get" class="buscar">
        <input type="text" placeholder="Buscar..." name="buscar">
      </form>
    </div>
      <div class="especialidad">
        <div class="separador">
          <h2><?php echo $titulo; ?></h2>
        </div>
        <div class="wrapper_medicos">
          <?php foreach($resultados as $medico): ?>
            <div class="medico">
              <img src="images/user.jpg" class="foto_medico" alt="">
              <div class="info_medico">
                <h4><?php echo $medico['nombre'];?></h4>
                <p><?php echo $medico['especialidad'];?></p>
                <p><?php echo $medico['horario de atencion'];?></p>
                </div>
                <button class="boton_medicos" onclick="displayTurnos()">Saca tu turno</button>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <footer>
      <div class="wrapper_footer">
        <img src="images/logo_camps.png" class="logo_footer">
          <h4>
            <img src="images/telefono.png" class="footer_icon">
            0381 494-1303
          </h4>
          <h4>
            <img src="images/ubicacion.png" class="footer_icon">
            Av. Rivadavia 877, Alderetes, Tucumán
          </h4>
      </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>