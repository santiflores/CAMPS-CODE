<?php require 'header.php' ?>
<h2><?php echo $titulo; ?></h2>
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

<?php require 'footer.php'; ?>