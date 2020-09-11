<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Medico - CAMPS</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lobster&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RUTA?>/css/stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="shortcut icon" type="image.png" href="images/favicon_CAMPS.png">
    <script src="<?php echo RUTA?>/js/scripts.js"></script>
    <script src="https://kit.fontawesome.com/aa681c14be.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php require 'header.php'?>
    <section class="form_editar">
      <form class="form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
        <input type="hidden" name="id" value="<?php echo $medico['id']; ?>">
        <input type="text" class="input-text" name="nombre" value="<?php echo $medico['nombre']; ?>">
        <input type="text" class="input-text" name="especialidad" value="<?php echo $medico['especialidad']; ?>">
        <input type="text" class="input-text" name="horario" value="<?php echo $medico['horario']; ?>">

        <input type="submit" class="input-submit" name="submit" value="Editar Medico">
      </form>
    </section>
    <?php require 'footer.php'?>
  </body>
</html>
