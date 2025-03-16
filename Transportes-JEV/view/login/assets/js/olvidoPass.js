const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});


/*-----------------------------------------------*/
/* Validacion de campos con expresiones regulares*/
/*-----------------------------------------------*/

const formulario = document.getElementById('formulario');
const entradas = document.querySelectorAll('#formulario input');

const expresiones = {
    nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos
    correo: /^[a-zA-Z0-9_.+-]+@(gmail\.com|hotmail\.com|outlook\.com|[a-zA-Z0-9-]+\.(org|com|net))$/,
	password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,50}$/
}

const campos = {
	nombre: false,
	correo: false,
	password: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;

		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
		break;

		case "password":
			validarCampo(expresiones.password, e.target, 'password');
		break;
	}
}

/* Validacion de password | Caracteres especiales */

const validarPassword = (password) => {
  const errores = [];

  // Regla: Al menos una letra minúscula
  if (!/[a-z]/.test(password)) {
      errores.push("Debe incluir al menos una letra minúscula.");
  }

  // Regla: Al menos una letra mayúscula
  if (!/[A-Z]/.test(password)) {
      errores.push("Debe incluir al menos una letra mayúscula.");
  }

  // Regla: Al menos un número
  if (!/\d/.test(password)) {
      errores.push("Debe incluir al menos un número.");
  }

  // Regla: Al menos un carácter especial
  if (!/[!@#$%^&*]/.test(password)) {
      errores.push("Debe incluir al menos un carácter especial (!@#$%^&*).");
  }

  // Regla: Longitud mínima de 8 caracteres
  if (password.length < 8) {
      errores.push("Debe tener al menos 8 caracteres.");
  }

  // Regla: Longitud máxima de 50 caracteres
  if (password.length > 50) {
      errores.push("Debe tener como máximo 50 caracteres.");
  }

  return errores;
};

// Escuchar los cambios en el campo de contraseña
const passwordInput = document.getElementById("passwordRegister");
const errorMessageP = document.getElementById("error-passwordMessage");

passwordInput.addEventListener("input", () => {
  const password = passwordInput.value;
  const errores = validarPassword(password);

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
  if (!(campos.correo && campos.password)) {
    e.preventDefault(); // Detener el envío

    // Mostrar el mensaje de error con estilos
    errorCamposMessageDiv.innerText = "Completa todos los campos correctamente antes de enviar"; // Mensaje dinámico
    errorCamposMessageDiv.style.display = "block"; // Hace visible el mensaje
    //console.log("Formulario detenido debido a campos inválidos");
  } else {
    // Si todo es válido, asegura que el mensaje de error esté oculto
    errorCamposMessageDiv.style.display = "none";
    console.log("Formulario enviado correctamente");
  }
});


/* Funcionalidad - ojo password */
document.addEventListener("DOMContentLoaded", () => {
    const pass = document.getElementById("passwordRegister");
    const icono = document.getElementById("password-eye");

    icono.addEventListener("click", () => {
        // Cambiar el tipo del input entre "password" y "text"
        if (pass.type === "password") {
            pass.type = "text"; // Mostrar la contraseña
            icono.classList.remove("fa-eye"); // Eliminar clase de "ojo abierto"
            icono.classList.add("fa-eye-slash"); // Agregar clase de "ojo cerrado"
        } else {
            pass.type = "password"; // Ocultar la contraseña
            icono.classList.remove("fa-eye-slash"); // Eliminar clase de "ojo cerrado"
            icono.classList.add("fa-eye"); // Agregar clase de "ojo abierto"
        }
    });
});

