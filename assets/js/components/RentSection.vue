<!-- src/js/components/RentSection.vue -->
<template>
  <section class="section__container steps__container" id="rent">
  <p class="section__subheader">COMMENT ÇA MARCHE ?</p>
  <h2 class="section__header">Louez en 3 étapes simples !</h2>
  <div class="steps__grid">
    <div class="steps__card">
      <span><i class="ri-map-pin-fill"></i></span>
      <h4>Choisissez un lieu</h4>
      <p>
        Sélectionnez le lieu de location souhaité parmi notre vaste réseau de points de location de voitures.
      </p>
    </div>
    <div class="steps__card">
      <span><i class="ri-calendar-check-fill"></i></span>
      <h4>Date de prise en charge</h4>
      <p>
        Indiquez la date et l'heure à laquelle vous souhaitez récupérer votre voiture avec des options de planification flexibles.
      </p>
    </div>
    <div class="steps__card">
      <span><i class="ri-bookmark-3-fill"></i></span>
      <h4>Réservez votre voiture</h4>
      <p>
        Parcourez notre large gamme de véhicules et choisissez celui qui convient le mieux à vos besoins.
      </p>
    </div>
  </div>
  </section>
</template>
  
  <script>
  export default {
    name: 'RentSection',
  };
  </script>
  
  <style scoped>
  /* Ajoutez ici les styles spécifiques pour RentSection.vue */
  </style>
  
  