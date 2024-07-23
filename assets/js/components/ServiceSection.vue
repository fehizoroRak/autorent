<!-- src/js/components/ServiceSection.vue -->
<template>

    <section class="section__container service__container" id="service">
  <div class="service__image">
    <img src="../../images/service.png" alt="service" />
  </div>
  <div class="service__content">
    <p class="section__subheader">MEILLEURS SERVICES</p>
    <h2 class="section__header">
      Vivez la meilleure expérience avec nos offres de location
    </h2>
    <ul class="service__list">
      <li>
        <span><i class="ri-price-tag-3-fill"></i></span>
        <div>
          <h4>Offres pour tous les budgets</h4>
          <p>
            Des voitures économiques aux véhicules de luxe, nous avons quelque chose pour tout le monde, garantissant le meilleur rapport qualité-prix.
          </p>
        </div>
      </li>
      <li>
        <span><i class="ri-wallet-fill"></i></span>
        <div>
          <h4>Meilleur prix garanti</h4>
          <p>
            Nous vous garantissons des tarifs compétitifs sur le marché, afin que vous puissiez réserver en toute confiance.
          </p>
        </div>
      </li>
      <li>
        <span><i class="ri-customer-service-fill"></i></span>
        <div>
          <h4>Support 24/7</h4>
          <p>
            Notre équipe est disponible 24/7 pour toutes questions ou remarques. 
          </p>
        </div>
      </li>
    </ul>
  </div>
</section>
  </template>
  
  <script>
  export default {
    name: 'ServiceSection',
  };
  </script>
  
  <style scoped>
  /* Ajoutez ici les styles spécifiques pour ServiceSection.vue */
  </style>
  

  