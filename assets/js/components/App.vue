<!-- src/js/components/App.vue -->
<template>
  <div>
    <Header />
    <main>
      <RentSection />
      <ServiceSection />
      <ExperienceSection />
      <DownloadSection />
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from './Header.vue';
import RentSection from './RentSection.vue';
import ServiceSection from './ServiceSection.vue';
import ExperienceSection from './ExperienceSection.vue';
import DownloadSection from './DownloadSection.vue';
import Footer from './Footer.vue';

export default {
  name: 'App',
  components: {
    Header,
    RentSection,
    ServiceSection,
    ExperienceSection,
    DownloadSection,
    Footer,
  },
};
</script>

<style scoped>
/* Ajoutez ici les styles spécifiques pour App.vue */
</style>
