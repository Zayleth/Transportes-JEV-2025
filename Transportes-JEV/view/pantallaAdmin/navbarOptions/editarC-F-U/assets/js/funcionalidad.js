/*-----------------------------------------------*/
/* Validacion de campos con expresiones regulares*/
/*-----------------------------------------------*/

const formulario = document.getElementById('formulario');
//const formularioLOGIN = document.getElementById('formularioLOGIN');

const entradas = document.querySelectorAll('#formulario input');

const expresiones = {
	origen: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos
    destino:/^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos
	precio: /^\d+(\.\d{1,2})?$/ // número entero (como "123"), número con hasta dos decimales (como "123.45"), no debe incluir letras ni símbolos adicionales
}

const campos = {
	origen: false,
	destino: false,
	precio: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "origen":
			validarCampo(expresiones.origen, e.target, 'origen');
		break;

		case "destino":
			validarCampo(expresiones.destino, e.target, 'destino');
		break;

		case "precio":
			validarCampo(expresiones.precio, e.target, 'precio');
		break;
	}
}

/* Validacion de precio | Caracteres especiales */

const validarPrecio = (precio) => {
  const errores = [];
  
  // Regla: Debe ser un número válido
  if (!precio) {
      errores.push("Debe ser un número válido con hasta dos decimales.");
  }

  // Regla: No puede ser negativo
  if (Number(precio) < 0) {
      errores.push("No puede ser un número negativo.");
  }

  // Regla: Solo debe contener números (enteros o decimales) / ningun símbolo
  if (!/^\d+(\.\d+)?$/.test(precio)) {
    errores.push("Solo se permiten números.");
  }


  // Regla: Longitud máxima de 50 caracteres
  if (precio.length > 50) {
      errores.push("Debe tener como máximo 50 caracteres.");
  }

  // Regla: Campo obligatorio
  if (!precio) {
      errores.push("El campo no puede estar vacío.");
  }

  return errores;
};


// Escuchar los cambios en el campo de precio
const precio_register = document.getElementById("precio");
const errorMessageP = document.getElementById("error-precioMessage");

precio_register.addEventListener("input", () => {
  const precio = precio_register.value;
  const errores = validarPrecio(precio);

  if (errores.length > 0) {
      // Mostrar el primer error detectado
      errorMessageP.innerText = errores[0];
      errorMessageP.style.display = "block"; // Hacer visible el mensaje
  } else {
      // Ocultar el mensaje si no hay errores
      errorMessageP.style.display = "none";
  }
});


const validarCampo = (expresion, input, campo) => {
    // Obtener el grupo específico
    const grupo = document.getElementById(`grupo__${campo}`);
    const icono = document.querySelector(`#grupo__${campo} .formulario__validacion-estado`); // Selecciona el ícono específico
    const error = grupo.querySelector(`.formulario__input-error`);

    //console.log(`Validando el campo: ${campo}, Valor: ${input.value}`); // Muestra el campo y su valor

    if (expresion.test(input.value)) {
        console.log(`${campo} es válido ✅`);
        // Validación exitosa
        grupo.classList.remove('formulario__grupo-incorrecto');
        grupo.classList.add('formulario__grupo-correcto');
        icono.classList.add('fa-check-circle'); // Cambia ícono a "correcto"
        icono.classList.remove('fa-times-circle'); // Quita ícono de "incorrecto"
        error.classList.remove('formulario__input-error-activo');
        campos[campo] = true;
    } else {
        console.log(`${campo} es inválido ❌`);
        // Validación fallida
        grupo.classList.add('formulario__grupo-incorrecto');
        grupo.classList.remove('formulario__grupo-correcto');
        icono.classList.add('fa-times-circle'); // Cambia ícono a "incorrecto"
        icono.classList.remove('fa-check-circle'); // Quita ícono de "correcto"
        error.classList.add('formulario__input-error-activo');
        campos[campo] = false;
    }
};

entradas.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});


/*-----------------------------------------------*/
/* Prevenir el envío si algún campo no es válido */
/*-----------------------------------------------*/

formulario.addEventListener('submit', (e) => {
  const errorCamposMessageDiv = document.getElementById('error-camposMessage'); // Selecciona el contenedor del mensaje de error

  // Verificar si todos los campos son válidos
  if (!(campos.origen && campos.destino && campos.precio)) {
      e.preventDefault(); // Detener el envío

      // Mostrar el mensaje de error con estilos
      errorCamposMessageDiv.innerText = "Completa todos los campos correctamente antes de enviar"; // Mensaje dinámico
      errorCamposMessageDiv.style.display = "block"; // Hace visible el mensaje
      //console.log("Formulario detenido debido a campos inválidos");
  } else {
      // Si todo es válido, asegura que el mensaje de error esté oculto
      errorCamposMessageDiv.style.display = "none";
      //console.log("Formulario enviado correctamente");
  }
});
