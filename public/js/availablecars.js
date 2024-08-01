
document.addEventListener('DOMContentLoaded', () => {
  // Carousel
  const prevButton = document.querySelector('.carousel-prev');
  const nextButton = document.querySelector('.carousel-next');
  const carouselContainer = document.querySelector('.carousel-container');
  const carouselItems = document.querySelectorAll('.carousel-item');
  let currentIndex = 0;
  const totalItems = carouselItems.length;
  const itemsToShow = 3;

  function updateCarousel() {
      const width = carouselItems[0].clientWidth;
      carouselContainer.style.transform = `translateX(${-currentIndex * width}px)`;
  }

  nextButton.addEventListener('click', () => {
      if (currentIndex < totalItems - itemsToShow) {
          currentIndex++;
      } else {
          currentIndex = 0;
      }
      updateCarousel();
  });

  prevButton.addEventListener('click', () => {
      if (currentIndex > 0) {
          currentIndex--;
      } else {
          currentIndex = totalItems - itemsToShow;
      }
      updateCarousel();
  });

  window.addEventListener('resize', updateCarousel);


});

