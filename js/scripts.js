function displayTurnos() {
	document.getElementById('wrapper_turno_padre').style.display='grid';
}
function cerrar_turno(){
	document.getElementById('wrapper_turno_padre').style.display='none'
}
function navDropdown() {
	document.getElementById('navbar_dropdown').style.display='block'
}
function navDropdownCerrar() {
	document.getElementById('navbar_dropdown').style.display='none'
}
function agregarEspecialidad() {
	var agregarEspecialidad = document.getElementById('agregar');
	if (agregarEspecialidad.style.display='none') {
		agregarEspecialidad.style.display ='block';
	} else if (agregarEspecialidad.style.display='block'){
		agregarEspecialidad.style.display='none';
	}
	return agregarEspecialidad;
}
function nuevaFila() {
		// var nueva_fila = 
		// 	<select name = 'dia' >
		// 		<option value="lunes">Lunes</option>
		// 		<option value="martes">Mates</option>
		// 		<option value="miercoles">Miercoles</option>
		// 		<option value="jueves">Jueves</option>
		// 		<option value="viernes">Viernes</option>
		// 	</select>
		// 	<label>Desde</label>
		// 	<select name="desde" id="">
	    //  </select>
		// 	<label>Duración del turno:</label>
		// 	<select name="intervalo">
		// 		<option value="PT15M">15 Minutos</option>
		// 		<option value="PT30M">30 minutos</option>
		// 	</select>
		// 	<label>Hasta</label>
		// 	<select name="hasta">
		//  </select>;
}