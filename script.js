 document.addEventListener("DOMContentLoaded", function () {
  aplicarModoGuardado();           // Aplica el modo guardado desde localStorage
  activarBotonModoOscuro();
  activarAlertasDeCompra();
});

// Esta función aplica el modo oscuro si estaba guardado
function aplicarModoGuardado() {
  const modo = localStorage.getItem("modo");
  const body = document.body;
  const btnModo = document.getElementById("modo-toggle");

  if (modo === "oscuro") {
    body.classList.add("dark-mode");
    if (btnModo) btnModo.textContent = "Modo Claro";
  } else {
    if (btnModo) btnModo.textContent = "Modo Oscuro";
  }
}

function activarBotonModoOscuro() {
  const btnModo = document.getElementById("modo-toggle");
  const body = document.body;

  if (btnModo) {
    btnModo.addEventListener("click", function () {
      const oscuro = body.classList.contains("dark-mode");

      if (oscuro) {
        body.classList.remove("dark-mode");
        btnModo.textContent = "Modo Oscuro";
        localStorage.setItem("modo", "claro");
      } else {
        body.classList.add("dark-mode");
        btnModo.textContent = "Modo Claro";
        localStorage.setItem("modo", "oscuro");
      }
    });
  }
}

// alerta al hacer clic en botones de compra
function activarAlertasDeCompra() {
  let botones = document.querySelectorAll("form[action='carrito.php'] button.btn-success");

  botones.forEach(function (boton) {
    boton.addEventListener("click", function (e) {
      e.preventDefault();
      alert("¡Producto añadido al carrito!");
      boton.closest("form").submit();
    });
  });
}



// opcion de mostrar contraseña en el registro
document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("verPassword");
  if (toggle) {
    toggle.addEventListener("change", function () {
      const campos = [
        document.getElementById("password"),
        document.getElementById("confirmar_password")
      ];

      campos.forEach(input => {
        if (input) {
          input.type = toggle.checked ? "text" : "password";
        }
      });
    });
  }
});


document.addEventListener("DOMContentLoaded", function () {
  const bienvenida = document.getElementById("bienvenida");
  if (bienvenida) {
    setTimeout(() => {
      bienvenida.style.display = "none";
    }, 4000);
  }
});






 