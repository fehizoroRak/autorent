<!-- src/js/components/Header.vue -->
<template>
  <header>
    <nav>
      <div class="nav__header">
        <div class="nav__logo">
          <a href="#">AutoRent</a>
        </div>
        <div class="nav__menu__btn" id="menu-btn">
          <i class="ri-menu-line"></i>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="#home">Accueil</a></li>
        <li><a href="#rent">Louer</a></li>
        <li><a href="#service">Services</a></li>
        <li><a href="#ride">Conduite</a></li>
        <li><a href="#contact">Contact</a></li>
        <li class="nav__links__btn">
          <button class="btn">Inscription</button>
        </li>
        <li class="nav__links__btn">
          <button class="btn">Connexion</button>
        </li>
      </ul>
      <div class="nav__btns">
        <button class="btn btn__primary">Inscription</button>
        <button class="btn btn__secondary">Connexion</button>
      </div>
    </nav>
    <div class="section__container header__container" id="home">
      <div class="header__image">
        <img src="../../images/header.png" alt="header" />
      </div>
      <div class="header__content">
        <h1>Looking to save more on your rental car?</h1>
        <p>
          Discover AutoRent car rental options in India with Rent a Car. Select
          from a range of car options and local specials.
        </p>
        
        <!-- Formulaire -->
        <form @submit.prevent="fetchVehicles">
          <div>
            <label for="pickupLocation">Lieu de prise en charge:</label>
            <input type="text" id="pickupLocation" v-model="pickupLocation" required />
          </div>
          <div>
            <label for="dropoffLocation">Lieu de retour:</label>
            <input type="text" id="dropoffLocation" v-model="dropoffLocation" required />
          </div>
          <div>
            <label for="startDate">Date de début:</label>
            <input type="date" id="startDate" v-model="startDate" required />
          </div>
          <div>
            <label for="endDate">Date de fin:</label>
            <input type="date" id="endDate" v-model="endDate" required />
          </div>
          <button type="submit">Voir les véhicules</button>
        </form>
        <VehicleList :vehicles="vehicles"></VehicleList>

      </div>
    </div>
  </header>
</template>

<script>
import VehicleList from './VehicleList.vue';

export default {
  name: 'Header',
  components: {
    VehicleList
  },
  data() {
    return {
      pickupLocation: '',
      dropoffLocation: '',
      startDate: '',
      endDate: '',
      vehicles: []
    };
  },
  methods: {
    async fetchVehicles() {
      // Simulating an API call
      this.vehicles = [
        { id: 1, name: 'Car 1', availability: 'Available' },
        { id: 2, name: 'Car 2', availability: 'Available' }
      ];
      // Replace with actual API call
      // const response = await fetch('/api/vehicles', {
      //   method: 'POST',
      //   headers: {
      //     'Content-Type': 'application/json'
      //   },
      //   body: JSON.stringify({
      //     pickupLocation: this.pickupLocation,
      //     dropoffLocation: this.dropoffLocation,
      //     startDate: this.startDate,
      //     endDate: this.endDate
      //   })
      // });
      // this.vehicles = await response.json();
    }
  }
};
</script>

<style scoped>
/* Ajoutez ici les styles spécifiques pour le header */
</style>
