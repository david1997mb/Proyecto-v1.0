<script setup>
import Calendar from '@/components/Calendar.vue'

</script>

<template>
<main>

<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../assets/img1.png" alt="salon" height="525" width="100%">
      <div class="container">
        <div class="carousel-caption text-start">
          <h1>Salon Señorial.</h1>
          <p class="opacity-75">El Salon esta ubicado sobre la avenida Suarez Miranda a 2 cuadras del Hospital Benigno Sanchez</p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../assets/img2.png" alt="servicio" height="525" width="100%">
      <div class="container">
        <div class="carousel-caption">
          <h1>Servicio Gastronomico</h1>
          <p>El Salon Cuenta Con un Excelente Servicio Gastronomico.</p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../assets/img.png" alt="decoracion" height="525" width="100%">
      <div class="container">
        <div class="carousel-caption text-end">
          <h1>Decoracion.</h1>
          <p>El salon Cuenta Con una muy Buena Decoracion de Ambientes para los Eventos.</p>          
        </div>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>

<hr class="featurette-divider">

<div class="container marketing">

  <div class="row">
    <div class="col-lg-4">
      <svg class="bd-placeholder-img rounded-circle" width="140" height="140" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
        <image href="../assets/img1.png" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" />
      </svg>
      <h2 class="fw-normal">Salon</h2>
      <p>El salón de eventos fue fundado en junio de 2000 por la familia Del-barco, lleva más de 20 años de servicio a la población en alquiler de espacio para todo acontecimiento social .</p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <svg class="bd-placeholder-img rounded-circle" width="140" height="140" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
        <image href="../assets/img2.png" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" />
      </svg>
      <h2 class="fw-normal">Servicio</h2>
      <p>El salón presta servicios de alquiler de espacio a 45 eventos social aproximadamente por año como todo negocio presenta tiempos buenos en los que se presenta más eventos .</p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <svg class="bd-placeholder-img rounded-circle" width="140" height="140" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
        <image href="../assets/img3.png" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" />
      </svg>
      <h2 class="fw-normal">Decorado</h2>
      <p>El Salon puede encargarse del decorado y presentar la mesa dulce para su evento.</p>
    </div><!-- /.col-lg-4 -->
  </div><!-- /.row -->

  <hr class="featurette-divider">
  
  <Calendar></Calendar>
  
  <hr class="featurette-divider">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="d-grid gap-2">
        <router-link to="pays/create" class="btn btn-dark btn-outline-light btn-sm">
          <i class="fa-solid fa-file-circle-plus"></i>
           &nbsp;&nbsp; INSERTAR NUEVO PAGO PARA CLIENTES
        </router-link>
      </div>
    </div>
  </div>
</div>

</main>
</template>
