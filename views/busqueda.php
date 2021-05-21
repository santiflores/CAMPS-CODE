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
        <div class="filtros">
            <b>Filtros</b>
            <div class="filtros--item">
                <b>Especialidad</b>
                <select name="especialidad" class="input-select filtro-input" id="filtro-select">
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
                    <input type="radio" class="filtro-input" name="sucursal" id="alderetes" value="alderetes" <?php if (!empty($_GET['sucursal'])){
                        if ($_GET['sucursal']=='alderetes') {
                            echo('checked');
                        }
                        }?>>
                    <label for="alderetes">Alderetes</label>
                </div>
                <div class="filtro-radio">
                    <input type="radio"  class="filtro-input" name="sucursal" id="BdRS" value="BdRS" disabled <?php if (!empty($_GET['sucursal'])){
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