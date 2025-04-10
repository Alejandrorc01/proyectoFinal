// llamadas a funciones

document.addEventListener("DOMContentLoaded", function () {
  activarBotonModoOscuro();
  activarAlertasDeCompra();
});



// Activa el botón para alternar entre modo claro y oscuro
function activarBotonModoOscuro() {
  let btnModo = document.getElementById("modo-toggle");
  let body = document.body;

  if (btnModo) {
    btnModo.addEventListener("click", function () {
      let oscuro = body.classList.contains("dark-mode");

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

// muestra  alerta por pantalla al hacer clic en botones de compra/reserva
function activarAlertasDeCompra() {
  let botones = document.querySelectorAll(".btn-success");

  botones.forEach(function (boton) {
    boton.addEventListener("click", function (e) {
      e.preventDefault();
      alert("¡Producto añadido al carrito!");
    });
  });
}


