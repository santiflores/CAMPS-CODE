const DOMelements = {

	nuevoHorarioBtn: document.getElementById('nuevo-horario-btn'),
	nuevoHorarioWrap: document.getElementById('nuevo-horario-wrap'),
	filasExistentes: document.querySelectorAll('.nueva-fila'),
	borrarFila: document.querySelectorAll('.border-button'),

	nuevoPrecioBtn: document.getElementById('nuevo-precio-btn'),
	nuevoPrecioWrap: document.getElementById('nuevo-precio-wrap'),
	borrarprecioBtn: document.getElementById('borrar-precio'),

	navDropBtn: document.querySelectorAll('.nav_boton_dropdown'),
	navDropdown: document.querySelector('#navbar_dropdown'),
	dropdownBtn: document.getElementById('boton_dropdown'),
	dropdown: document.getElementById('agregar'),
	bookForm: document.getElementById('reservar_turno'),
	CalenDays: document.querySelectorAll(".calen-dia"),
	dataInput: document.getElementById("selected-day"),
	fechaEnUI: document.getElementById("fecha-del-turno"),
	CalenHoras: document.querySelectorAll(".horarios"),
	dataInputTime: document.getElementById("selected-time"),
	horaEnUI: document.getElementById("hora-del-turno"),
	borrarBtns: document.querySelectorAll(".borrar-btn")

}

function displayDropdown(button, dropdown) {
	button.forEach(el=>{
		el.addEventListener('click', ()=>{
			if (dropdown.style.display == 'block') {
				dropdown.style.display='none';
			} else {
				dropdown.style.display='block';
			}
		});
	})
}

displayDropdown(DOMelements.navDropBtn, DOMelements.navDropdown);

if (DOMelements.dropdownBtn != null) {
	displayDropdown(DOMelements.dropdownBtn, DOMelements.dropdown);
}



if (DOMelements.nuevoHorarioBtn != null) {
	var filasExistentes = DOMelements.filasExistentes;
	if (filasExistentes.length == 0) {
		var fila = 0;	
	} else {
		var fila = DOMelements.filasExistentes[DOMelements.filasExistentes.length - 1];
		fila = fila.id.split('fila');
		fila = parseInt(fila[1]) + 1;
	}

	DOMelements.nuevoHorarioBtn.addEventListener('click', function() {
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
		<div id="nueva-fila${fila}" class="nueva-fila">
			<label>Dia:</label>
				<select class="input-select" name = "fila[${fila}][dia]">
				<option value="lunes">Lunes</option>
				<option value="martes">Martes</option>
				<option value="miercoles">Miercoles</option>
				<option value="jueves">Jueves</option>
				<option value="viernes">Viernes</option>
			</select>
			<br>		
			<label>Desde</label>
			<select class="input-select" name="fila[${fila}][desde]" id="desde${fila}"></select>
		
			<label>Hasta</label>
			<select class="input-select" name="fila[${fila}][hasta]" id="hasta${fila}"></select>
			<br>		
			<label>Duración del turno:</label>
			<select class="input-select" name="fila[${fila}][intervalo]">
				<option value="15">15 Minutos</option>
				<option value="30">30 minutos</option>
			</select>
		</div>`;
		
		DOMelements.nuevoHorarioWrap.insertAdjacentHTML('beforeend', nuevaFilaHTML);
		
		for (let i = 0; i < horarios.length; i++) {
			
			document.getElementById('desde' + fila).innerHTML += '<option value="' + horarios[i] + '">' + horarios[i] + '</option>';
			document.getElementById('hasta' + fila).innerHTML += '<option value="' + horarios[i] + '">' + horarios[i] + '</option>';
		}
		fila++;
		return fila;
	});
}


if (DOMelements.nuevoPrecioBtn != null) {
	var filasExistentes = DOMelements.filasExistentes;
	if (filasExistentes.length == 0) {
		var valor = 0;	
	} else {
		var valor = DOMelements.filasExistentes[DOMelements.filasExistentes.length - 1];
		valor = valor.id.split('fila');
		valor = parseInt(valor[1]) + 1;
	}
	DOMelements.nuevoPrecioBtn.addEventListener('click', function() {
		
		var nuevaFilaHTML = `
		<div id="nueva-fila${valor}" class="nueva-fila">
		
		<label><b>Tipo:</b></label>
		<input type="text" class="input-text" name="valor[${valor}][tipo]" placeholder="Ej: Asispre, OSDE, etc">		
		<label><b>Valor:</b></label>
		<input type="number" class="input-text" name="valor[${valor}][valor]">
		</div>`;
		
		DOMelements.nuevoPrecioWrap.insertAdjacentHTML('beforeend', nuevaFilaHTML);
		
		valor ++;
		return valor;
	});
}

if (DOMelements.borrarFila != null) {
	let precioBorradoCount = 0;
	let horarioBorradoCount = 0;
	DOMelements.borrarFila.forEach(el => {
		el.addEventListener('click', ()=>{
			let id = el.id;
			let parentNode;
			switch (id) {
				case 'borrar-horario':
					parentNode = document.querySelector('#nuevo-horario-wrap');
					let horarioBorrado = parentNode.removeChild(parentNode.lastElementChild);
					horarioBorrado = horarioBorrado.firstElementChild.value;
					if (horarioBorrado != null) {
						DOMelements.nuevoHorarioWrap.insertAdjacentHTML('beforebegin', `
							<input type="hidden" name="horario_borrado_id[${horarioBorradoCount}]" value="${horarioBorrado}">
						`);
						horarioBorradoCount += 1;
					}
					fila -= 1;
					break;
				case 'borrar-precio':
					parentNode = document.querySelector('#nuevo-precio-wrap')
					let valorBorrado = parentNode.removeChild(parentNode.lastElementChild);
					valorBorrado = valorBorrado.firstElementChild.value;
					console.log(valorBorrado);
					if (valorBorrado != null) {
						DOMelements.nuevoPrecioWrap.insertAdjacentHTML('beforebegin',`
							<input type="hidden" name="precio_borrado_id[${precioBorradoCount}]" value="${valorBorrado}">
						`);
						precioBorradoCount += 1;
					}
					valor -= 1;
					break;
				default:
					break;
				}
		})		
	});
}

if (DOMelements.dataInput != null) {
	
	DOMelements.CalenDays.forEach(function(day) {
		if (day.className  != 'calen-dia dia-bloqueado') {
			day.addEventListener('click',function() {
				
				DOMelements.CalenDays.forEach(function name(day) {
					day.classList.remove('calen-dia--focus')
				})
				day.classList.add('calen-dia--focus');
				var curDataDate = day.dataset.selectedDate;
				DOMelements.dataInput.value = curDataDate;
				DOMelements.fechaEnUI.innerHTML = curDataDate;
				DOMelements.bookForm.submit();
			});
		}
	})

}
		
if (DOMelements.dataInputTime != null) {
	
	DOMelements.CalenHoras.forEach(function(day) {
		day.addEventListener('click',function() {
			
			DOMelements.CalenHoras.forEach(function name(day) {
				day.classList.remove('calen-dia--focus')
			})
			day.classList.add('calen-dia--focus');
			var curDataHora = day.dataset.selectedTime;
			DOMelements.dataInputTime.value = curDataHora;
			DOMelements.horaEnUI.innerHTML = curDataHora;
			DOMelements.bookForm.sumbit();
		});
	})

}

if (DOMelements.borrarBtns != null) {
	DOMelements.borrarBtns.forEach(function(btn) {
		btn.addEventListener('click', function(){

			var btnId, title, text, link, options, HTMLverif;
			btnId = btn.id;
			link = btn.dataset.route;
			switch (btnId) {
				case 'turno':
					title = '¿Esta seguro/a que quiere cancelar su turno?';
					text = 'Si cancela su turno no podra recuperarlo y debera reprogramarlo.';
					options = ['No, conservar turno', 'Si, cancelar turno'];
				break;
				case 'medico':
					title = '¿Estas seguro/a que deseas dar de baja este medico?';
					text = 'Si das de baja a este medico se eliminará por completo y no podrás recuperar la información de este.';
					options = ['No, conservar medico', 'Si, eliminar medico'];
				break;
				case 'especialidad':
					title = '¿Esta seguro/a de que quiere eliminar esta especialidad?';
					text = 'Si la elimina, todos los medicos dentro de esta especialidad no estaran disponibles para el publico.';
					options = ['No, conservar especialidad', 'Si, eliminar especialidad'];				
				break;
				default:
				break;
			}
			HTMLverif = document.createElement("div");
			document.body.appendChild(HTMLverif);
			HTMLverif.className = ('verificacion');
			HTMLverif.innerHTML = `
				<div class="flex-center-start verificacion--title">
					${title}
				</div>
				<div class="verificacion--body">
					<p>${text}</p>
				</div>
				<div class="verificacion--buttons">
					<a href="" class="flex-center verificacion--button">${options[0]}</a>
					<a href="${link}" class="flex-center verificacion--danger">${options[1]}</a>
				</div>
			`;
			
		})
	})
}
