<script setup>
import { useAuthStore } from '../stores/auth'
const authStore = useAuthStore();

</script>
<template>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid px-lg-5">
    <li></li>
    <router-link to="/" class="nav-link">
      <h4 class="h4 text-white "> Salon De Eventos Señorial Quillacollo </h4>
    </router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#MenuLateral" aria-controls="MenuLateral" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="MenuLateral" aria-labelledby="MenuLateralLabel">
      <div class="offcanvas-header">
        <h4 class="offcanvas-title" id="MenuLateralLabel">Navegacion del Salon</h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item px-lg-5">
            <router-link to="/" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-house"></i>&nbsp;Inicio</router-link>
          </li>
          <li class="nav-item px-lg-5" v-if="!authStore.user">
            <router-link to="/login" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-user"></i>&nbsp;Iniciar Sesion</router-link>
          </li>          
          <hr>
        </ul>
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" v-if="authStore.user">
          <li class="nav-item dropdown px-lg-5">
            <a class="btn btn-dark text-white btn-lg nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-users"></i>&nbsp;Clientes
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li>
                <router-link to="/clients" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-users"></i>&nbsp;Lista Clientes</router-link>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <router-link to="/clientsgrafic" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-database"></i>&nbsp;Grafico Clientes</router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown px-lg-5">
            <a class="btn btn-dark text-white btn-lg nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-martini-glass-citrus"></i>&nbsp;Events
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li>
                <router-link to="/events" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-users"></i>&nbsp;Lista Eventos</router-link>
              </li>
              <li>
                <router-link to="/events/create" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-circle-plus"></i>&nbsp;Crear Eventos</router-link>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <router-link to="/eventsgrafic" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-database"></i>&nbsp;Grafico Eventos</router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown px-lg-5">
            <a class="btn btn-dark text-white btn-lg nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-regular fa-square-check"></i>&nbsp;Areas
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li>
                <router-link to="/areas" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-scroll"></i>&nbsp;Lista Areas</router-link>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <router-link to="/areasgrafic" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-database"></i>&nbsp;Grafico Areas</router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown px-lg-5">
            <a class="btn btn-dark text-white btn-lg nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-comments-dollar"></i>&nbsp;Pagos
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li>
                <router-link to="/pays" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-scroll"></i>&nbsp;Lista Pagos</router-link>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <router-link to="/paysgrafic" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-database"></i>&nbsp;Grafico Pagos</router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item px-lg-5">
            <router-link to="/users" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-users-line"></i>&nbsp;Usuarios</router-link>
          </li>
          <li class="nav-item px-lg-5">
            <router-link to="/reports" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-chart-simple"></i>&nbsp;Reportes</router-link>
          </li>
          <li class="nav-item px-lg-5">
            <router-link to="/reporte" class="btn btn-dark text-white btn-lg nav-link" aria-current="page"><i class="fa-solid fa-chart-simple"></i>&nbsp;Reportes</router-link>
          </li>
          <hr>
        </ul>
        <ul class="navbar-nav flex-grow-1 pe-3" v-if="authStore.user">
          <li class="nav-item dropdown px-lg-5">
            <a class="btn btn-dark text-white btn-lg nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="rounded-circle me-2 fa-solid fa-user"></i>
              <strong>
                {{ authStore.user.name.toUpperCase() }}
              </strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li class="nav-item px-lg-5">
                <button @click="authStore.logout" class="btn btn-dark text-white btn-lg nav-link" >
                  <i class="fa-solid fa-user-large-slash"></i>&nbsp;Cerrar Sesion
                </button>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
</template>
