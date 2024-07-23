<!-- src/js/components/VehicleList.vue -->
<template>
    <div>
      <h3>Available Vehicles</h3>
      <ul>
        <li v-for="vehicle in vehicles" :key="vehicle.id">
          {{ vehicle.name }} - {{ vehicle.availability }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    name: 'VehicleList',
    props: {
      vehicles: {
        type: Array,
        required: true
      }
    }
  };
  </script>
  
  <style scoped>
  /* Ajoutez ici les styles spécifiques pour VehicleList.vue */
  </style>
  