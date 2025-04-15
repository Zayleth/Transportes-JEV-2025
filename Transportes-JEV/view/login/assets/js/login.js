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
//const formularioLOGIN = document.getElementById('formularioLOGIN');

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
const password_register = document.getElementById("passwordRegister");
const errorMessageP = document.getElementById("error-passwordMessage");

password_register.addEventListener("input", () => {
  const password = password_register.value;
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
/* Prevenir el envío si algún campo no es válido FORMULARIO DE REGISTRO */
/*-----------------------------------------------*/

formulario.addEventListener('submit', (e) => {
  const errorCamposMessageDiv = document.getElementById('error-camposMessage'); // Selecciona el contenedor del mensaje de error

  // Verificar si todos los campos son válidos
  if (!(campos.nombre && campos.correo && campos.password)) {
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


//Funcionalidad - ojo password REGISTER 
document.addEventListener("DOMContentLoaded", () => {
  const password_register = document.getElementById("passwordRegister");
  const toggleIcon = document.getElementById("password-eye");

  toggleIcon.addEventListener("click", () => {
      // Cambiar el tipo del input entre "password" y "text"
      if (password_register.type === "password") {
          password_register.type = "text"; // Mostrar la contraseña
          toggleIcon.classList.remove("fa-eye"); // Eliminar clase de "ojo abierto"
          toggleIcon.classList.add("fa-eye-slash"); // Agregar clase de "ojo cerrado"
      } else {
          password_register.type = "password"; // Ocultar la contraseña
          toggleIcon.classList.remove("fa-eye-slash"); // Eliminar clase de "ojo cerrado"
          toggleIcon.classList.add("fa-eye"); // Agregar clase de "ojo abierto"
      }
  });
});

// Mensaje de error - Correo ya existente

document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);

  // Detecta si el parámetro "show=register" está en la URL
  if (params.get("show") === "register") {
      const main = document.querySelector("main"); // Selecciona el contenedor principal
      if (main) {
          main.classList.add("sign-up-mode"); // Muestra el formulario de registro

          const emailInput = document.getElementById("correo"); // Selecciona el input de correo
          const errorDiv = document.querySelector(".error-message"); // Selecciona el contenedor del mensaje de error
      
          // Evento para ocultar el mensaje de error cuando el usuario escribe
          emailInput.addEventListener("input", () => {
              if (errorDiv) {
                errorDiv.style.display = "none"; // Oculta el mensaje de error
                errorDiv.textContent = ""; // Limpia el contenido del mensaje
              } else {
                // Asegúrate de ocultar el mensaje si no hay error
                const errorDiv = document.querySelector(".error-message");
                  if (errorDiv) {
                    errorDiv.style.display = "none";
                  }	
              }
          });
        }
    }
});


// Limpiar el "mensaje de error" cuando el usuario empiece a escribir en el input (correo)
document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.getElementById("correo"); // Selecciona el input de correo
    const errorDiv = document.querySelector(".error-message"); // Selecciona el contenedor del mensaje de error

    // Evento para ocultar el mensaje de error cuando el usuario escribe
    emailInput.addEventListener("input", () => {
        if (errorDiv) {
        	errorDiv.style.display = "none"; // Oculta el mensaje de error
          errorDiv.textContent = ""; // Limpia el contenido del mensaje
        }
    });
});


// Eliminación de "Usuario registrado correctamente" luego de 10s
document.addEventListener("DOMContentLoaded", () => {
	const successMessage = document.querySelector(".success-message");
	const failMessage = document.querySelector(".failed-registration-message");
	// const fail_LogIn_Message = document.querySelector(".failed-logIn-message");

	if (successMessage) {
	  setTimeout(() => {
		successMessage.style.display = "none"; // Oculta el mensaje después de 10 segundos
	  }, 10000); // 10000 ms = 10 segundos
	}

	if (failMessage) {
		setTimeout(() => {
		  failMessage.style.display = "none"; // Oculta el mensaje después de 10 segundos
		}, 10000); // 10000 ms = 10 segundos
	}

	/*
	if (fail_LogIn_Message) {
		setTimeout(() => {
			fail_LogIn_Message.style.display = "none"; // Oculta el mensaje después de 10 segundos
		}, 10000); // 10000 ms = 10 segundos
	}
	*/
});
