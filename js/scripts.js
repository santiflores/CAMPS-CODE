const DOMelements = {
	nuevaFilaBtn: document.querySelector('#nueva-fila-btn'),
	navDropdown: document.querySelector('#navbar-dropdown'),
	agregarEsp: document.querySelector('#agregar'),
	borrarFilaBtn: document.getElementById('borrar-fila'),
	nuevaFilaWrap: document.getElementById('nueva-fila-wrap')
}

function navDropdown() {
	DOMelements.navDropdown.style.display='block'
}

function navDropdownCerrar() {
	DOMelements.navDropdown.style.display='none'
}

function agregarEspecialidad() {
	DOMelements.agregarEsp.style.display ='block';
}

DOMelements.borrarFilaBtn.addEventListener('click', function(){
	let ultimafila = document.querySelector(`#nueva-fila${fila - 1}`);
	ultimafila.innerHTML('');
});


var fila = 0
DOMelements.nuevaFilaBtn.addEventListener('click', function() {
	var x = 30; //minutes interval
	var horarios = []; // time array
	var inicio = 7 * 60; // start time
	//loop to increment the time and push results in array
	for (var i = 0; inicio <= (20 * 60); i++) {
		var hh = Math.floor(inicio / 60); // getting hours of day in 0-24 format
		var mm = (inicio % 60); // getting minutes of the hour in 0-55 format
		horarios[i] = ("0" + hh).slice(-2) + ':' + ("0" + mm).slice(-2); // pushing data in array in [00:00 - 12:00 AM/PM format]
		inicio += x;
	}

	var nuevaFilaHTML = `
		<div id="nueva-fila${fila}">
			<select name = "fila[${fila}][dia]">
				<option value="lunes">Lunes</option>
				<option value="martes">Mates</option>
				<option value="miercoles">Miercoles</option>
				<option value="jueves">Jueves</option>
				<option value="viernes">Viernes</option>
			</select>
	
			<label>Desde</label>
			<select name="fila[${fila}][desde]" id="desde${fila}"></select>
	
			<label>Duración del turno:</label>
			<select name="fila[${fila}][intervalo]">
				<option value="15">15 Minutos</option>
				<option value="30">30 minutos</option>
			</select>
	
			<label>Hasta</label>
			<select name="fila[${fila}][hasta]" id="hasta${fila}"></select>
		</div>`;

	DOMelements.nuevaFilaWrap.insertAdjacentHTML('beforeend', nuevaFilaHTML);

	for (let i = 0; i < horarios.length; i++) {

		document.getElementById('desde' + fila).innerHTML += '<option value="' + horarios[i] + '">' + horarios[i] + '</option>';
		document.getElementById('hasta' + fila).innerHTML += '<option value="' + horarios[i] + '">' + horarios[i] + '</option>';
	}
	fila++;
	return fila;
});


// TO DO: Borrar Fila