<?php
$titulo = "Inicio";
include("includes/header.php");
?>

<div class="contenedorgeneral">
  <br />

  <!-- reservas -->
  <h1>RESERVA TU JUEGO</h1>

  <div class="row justify-content-center">
    <!-- Tarjeta 1 -->
    <div class="col-sm-12 col-lg-4 p-3">
      <div class="card" style="height: 100%">
        <div class="card-body">
          <img class="mariotarjeta" src="imagenesindex/227154.png" alt="TOPSPIN 24" />
          <br /><br />
          <h5 class="card-title">TOPSPIN 24</h5>
          <p class="card-text textotarjetas">
            Disfruta del máximo nivel de competición del tenis profesional
          </p>
          <p class="card-text textotarjetas">69.99€</p>
          <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-success">Resérvalo ya</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Tarjeta 2 -->
    <div class="col-sm-12 col-lg-4 p-3">
      <div class="card" style="height: 100%">
        <div class="card-body">
          <img class="mariotarjeta" src="imagenesindex/228962.png" alt="MOTOGP 24" />
          <br /><br />
          <h5 class="card-title">MOTOGP 24</h5>
          <p class="card-text textotarjetas">
            Súbete a tu moto, corre en los circuitos y conviértete en campeón
          </p>
          <p class="card-text textotarjetas">69.99€</p>
          <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-success">Resérvalo ya</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Tarjeta 3 -->
    <div class="col-sm-12 col-lg-4 p-3">
      <div class="card" style="height: 100%">
        <div class="card-body">
          <img class="mariotarjeta" src="imagenesindex/230443.png" alt="KINGDOM COME" />
          <br /><br />
          <h5 class="card-title">KINGDOM COME DELIVERANCE II</h5>
          <p class="card-text textotarjetas">
            Siente el choque del acero y el combate visceral
          </p>
          <p class="card-text textotarjetas">69.99€</p>
          <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-success">Resérvalo ya</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Banner de oferta -->
  <div id="banner" class="alert alert-warning fade show text-center border border-white" role="alert"
    style="background-color: #198754; color: #fff">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <h4 class="alert-heading">¡No te pierdas nuestra mejor oferta semanal!</h4>
    <p class="mb-0">¡Descuento de un <strong>20%</strong> en la PS5 Slim!</p>
  </div>
  <br /><br />

  <!-- Carrusel -->
  <div class="container">
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
          aria-label="Slide 2"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="imagenesindex/PS5-Slim-Hero-3.webp" class="d-block w-100" alt="PS5 Oferta" />
          <div class="carousel-caption">
            <h5><a href="ps5.php" id="compralaya">Cómprala ya!</a></h5>
            <p class="precio">NUEVO PRECIO: 499.99€</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="imagenesindex/303490_00_3.jpg" class="d-block w-100" alt="PS5 Oferta 2" />
          <div class="carousel-caption">
            <h5><a href="ps5.php" id="compralaya">Cómprala ya!</a></h5>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Novedades -->
    <br /><br />
    <h1>NOVEDADES EN VIDEOJUEGOS</h1>
    <div class="row justify-content-center">
      <div class="col-sm-12 col-lg-6 mb-3 mb-sm-0 py-3">
        <div class="card" style="height: 100%">
          <div class="card-body">
            <img class="f1tarjeta" src="imagenesindex/1124-ea-sports-f1-2024-ps5.webp" alt="F1 24" />
            <br /><br />
            <h5 class="card-title">F1 24</h5>
            <p class="card-text textotarjetas">
              Apura la frenada con el videojuego oficial de la FIA 2024
            </p>
            <div class="d-flex justify-content-center">
              <a href="#" class="btn btn-success">Cómpralo ya</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-lg-6 py-3">
        <div class="card" style="height: 100%">
          <div class="card-body">
            <img class="mariotarjeta" src="imagenesindex/81fKbEWOwzL.jpg" alt="PAPER MARIO" />
            <br /><br />
            <h5 class="card-title">PAPER MARIO LA PUERTA MILENARIA</h5>
            <p class="card-text textotarjetas">
              Comienza la búsqueda de los cristales estelares con Mario
            </p>
            <div class="d-flex justify-content-center">
              <a href="#" class="btn btn-success">Cómpralo ya</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
