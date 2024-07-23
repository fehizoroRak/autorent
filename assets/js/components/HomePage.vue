<template>
    <div>
      <header-component></header-component>
      <section class="section__container header__container" id="home">
        <!-- Existing header content -->
        <div class="header__content">
          <h1>Looking to save more on your rental car?</h1>
          <p>Discover RentalX car rental options in India with Rent a Car. Select from a range of car options and local specials.</p>
          <div class="header__links">
            <a href="#"><img src="@/assets/store.jpg" alt="app store" /></a>
            <a href="#"><img src="@/assets/play.png" alt="play" /></a>
          </div>
        </div>
      </section>
      
      <section class="section__container form__container">
        <h2>Find Your Rental Car</h2>
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
        <vehicle-list :vehicles="vehicles"></vehicle-list>
      </section>
      
      <steps-component></steps-component>
      <services-component></services-component>
      <experience-component></experience-component>
      <download-component></download-component>
      <footer-component></footer-component>
    </div>
  </template>
  
  <script>
  import HeaderComponent from './HeaderComponent.vue';
  import StepsComponent from './StepsComponent.vue';
  import ServicesComponent from './ServicesComponent.vue';
  import ExperienceComponent from './ExperienceComponent.vue';
  import DownloadComponent from './DownloadComponent.vue';
  import FooterComponent from './FooterComponent.vue';
  import VehicleList from './VehicleList.vue';
  
  export default {
    components: {
      HeaderComponent,
      StepsComponent,
      ServicesComponent,
      ExperienceComponent,
      DownloadComponent,
      FooterComponent,
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
  
  <style>
  /* Add your styles here */
  </style>
  