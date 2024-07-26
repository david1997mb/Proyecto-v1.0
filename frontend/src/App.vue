<script setup>
import { RouterView } from 'vue-router'
import Nav from './components/Nav.vue';
import Footer from './components/Footer.vue';
</script>

<template>
  <Nav></Nav> <br><br><br>
  <div class="container-fluid mt-5">
    <RouterView />
  </div>
  <div class="container-fluid">  
    <Footer></Footer>
  </div>

</template>
<style>

  body {
  background-image: url('./assets/Telegram.jpg');
  background-repeat: no-repeat;
  background-size: cover;
}

</style>