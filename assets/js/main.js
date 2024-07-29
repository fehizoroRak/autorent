
//MAIN.JS START
console.log('object');
const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {

  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1000,
};

ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".header__links", {
  ...scrollRevealOption,
  delay: 1500,
});

ScrollReveal().reveal(".steps__card", {
  ...scrollRevealOption,
  interval: 500,
});

ScrollReveal().reveal(".service__image img", {
  ...scrollRevealOption,
  origin: "left",
});
ScrollReveal().reveal(".service__content .section__subheader", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".service__content .section__header", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".service__list li", {
  ...scrollRevealOption,
  delay: 1500,
  interval: 500,
});

ScrollReveal().reveal(".experience__card", {
  duration: 1000,
  interval: 500,
});

ScrollReveal().reveal(".download__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".download__content .section__header", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".download__content p", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".download__links", {
  ...scrollRevealOption,
  delay: 1500,
});
//MAIN.JS END


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

  // Modal functionality
  const infoIcons = document.querySelectorAll('.info-icon');
  const modal = document.getElementById("carModal");
  const span = document.getElementsByClassName("close")[0];
  const modalBody = document.querySelector(".modal-body");

  infoIcons.forEach(icon => {
      icon.addEventListener('click', (e) => {
          const carItem = e.target.closest('.carousel-item') || e.target.closest('.cars__item');
          const carData = {
              brand: carItem.dataset.brand,
              model: carItem.dataset.model,
              year: carItem.dataset.year,
              color: carItem.dataset.color,
              registration: carItem.dataset.registration,
              nbofcardoors: carItem.dataset.nbofcardoors,
              nbofpersons: carItem.dataset.nbofpersons,
              airconditionner: carItem.dataset.airconditionner === 'true' ? 'Oui' : 'Non',
              gearbox: carItem.dataset.gearbox,
              horsepower: carItem.dataset.horsepower,
              co2emissions: carItem.dataset.co2emissions,
              electric: carItem.dataset.electric === 'true' ? 'Oui' : 'Non',
              image: carItem.dataset.image,
              dayprice: carItem.dataset.dayprice,
              days: carItem.dataset.days,
              totalperday: carItem.dataset.totalperday,
          };

          modalBody.innerHTML = `
              <div class="">
                  <div class="info">
                      <img src="/images/${carData.image}" alt="${carData.brand} ${carData.model}" class="modal-car-image">
                      <div>
                          <h2>${carData.brand} ${carData.model}</h2>
                      </div>
                  </div>
              </div>
              <div class="rect-box">
                  <div class="details" style="margin-bottom:1.5rem;">
                      <p><i class="ri-calendar-line"></i>${carData.year}</p>
                      <p><i class="ri-palette-line"></i> ${carData.color}</p>
                      <p><i class="ri-car-line"></i> ${carData.registration}</p>
                      <p>Portes: ${carData.nbofcardoors}</p>
                      <p><i class="ri-user-line"></i> ${carData.nbofpersons} pers.</p>
                  </div>
                  <div class="details">
                      <p><i class="fa-solid fa-snowflake"></i>Climatisation ${carData.airconditionner}</p>
                      <p>Boîte: ${carData.gearbox}</p>
                      <p>Puissance: ${carData.horsepower} CV</p>
                      <p><i class="ri-cloud-line"></i> ${carData.co2emissions} g/km</p>
                      <p>Électrique: ${carData.electric}</p>
                  </div>
              </div>
              <div class="rect-box inclus">
                  <h5 style="color:#fe5b3e;margin-bottom:0.8rem;">INCLUS</h5>
                  <p style="font-size:1.5rem; font-weight: 700;margin-bottom:0.6rem;">Protection Basic</p>
                  <p style="font-size:1rem; font-weight: 700;margin-bottom:0.9rem;">Franchise à 2 500,00 €</p>
                  <ul style="margin-left:0.9rem;" >
                      <li style="margin-bottom:0.9rem;" > <i style="color:green;" class="fa-solid fa-check"></i>  Protection contre les dommages résultant d'une collision</li>
                     <li> <i style="color:green;margin-bottom:1.2rem;"  class="fa-solid fa-check"></i>  Protection contre le vol</li>
                  </ul>
                  <p>  <i style="font-size:1.2rem; color:#616161;" class="fa-solid fa-circle-info"></i>  Vous pourrez modifier votre protection après avoir sélectionné ce véhicule</p>
              </div>
              <div class="prices">
                  <p>À PARTIR DE</p>
                  <p class="price-text" style="text-align:center;">${carData.dayprice} € / jour</p>
                  <p class="total-per-day">TOTAL ${carData.totalperday} €</p>
              </div>
          `;

          modal.style.display = "block";
      });
  });

  span.onclick = function() {
      modal.style.display = "none";
  }

  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
});

// SCRIPT FOR BUTTON SELECTIONNER

document.addEventListener('DOMContentLoaded', function() {
  const selectButtons = document.querySelectorAll('.select-btn');

  selectButtons.forEach(button => {
      button.addEventListener('click', function() {
          const carItem = this.closest('.carousel-item') || this.closest('.cars__item');
          const brand = carItem.dataset.brand;
          const model = carItem.dataset.model;
          const image = carItem.dataset.image;
          const dayPrice = parseFloat(carItem.dataset.dayprice);
          const days = parseInt(carItem.dataset.days, 10);
          const totalPerDay = parseFloat(carItem.dataset.totalperday);

          // Calculate online price with 9% discount
          const onlineDayPrice = dayPrice * 0.91;
          const onlineTotal = onlineDayPrice * days;

          const modal = document.querySelector('.modal-select');
          const modalDetails = modal.querySelector('.car-details');
          const modalPrice = modal.querySelector('.price');
          const modalTotal = modal.querySelector('.total');

          modalDetails.querySelector('h1').textContent = `Choisissez le tarif qui vous convient`;

          // Update the innerHTML and apply CSS style
          const detailsParagraph = modalDetails.querySelector('h2');
          detailsParagraph.innerHTML = `${brand} ${model}`;
          detailsParagraph.style.margin = '15px 0'; // Apply margin

          modalDetails.querySelector('img').src = `/images/${image}`;
          modalDetails.querySelector('img').alt = `${brand} ${model}`;

          // Update "Payer en agence" section
          modal.querySelector('.option .price').textContent = `${dayPrice.toFixed(2)} € / jour`;
          modal.querySelector('.option .total').textContent = `TOTAL ${totalPerDay.toFixed(2)} €`;

          // Update "Payer en ligne" section
          modal.querySelector('.option.online .price').textContent = `${onlineDayPrice.toFixed(2)} € / jour`;
          modal.querySelector('.option.online .total').textContent = `TOTAL ${onlineTotal.toFixed(2)} €`;

          modal.style.display = 'block';
      });
  });

  // Optional: Add close functionality for your modal
  document.querySelector('.modal-select .close-selectionner').addEventListener('click', function() {
      document.querySelector('.modal-select').style.display = 'none';
  });
});

document.addEventListener('DOMContentLoaded', function() {
  // Attach click event listeners to all "Sélectionner" buttons
  document.querySelectorAll('.cars__list .select-btn').forEach(button => {
      button.addEventListener('click', function() {
          // Find the closest list item that represents the car data
          const carItem = this.closest('.cars__item');

          // Fetch data from the car item, assuming data attributes are set like data-brand="Toyota"
          const brand = carItem.querySelector('.cars__details h1').textContent.split(' ')[0]; // Gets the brand and model
          const model = carItem.querySelector('.cars__details h1').textContent.split(' ')[1];
          const image = carItem.querySelector('.cars__image img').src;
          const dayPrice = parseFloat(carItem.querySelector('.cars__price .price-text').textContent);
          const days = parseInt(carItem.dataset.days, 10);
          const totalPerDay = dayPrice * days;

          // Calculate online price with 9% discount
          const onlineDayPrice = dayPrice * 0.91;
          const onlineTotal = onlineDayPrice * days;

          // Get the modal and populate it with the car data
          const modal = document.querySelector('.modal-select');
          modal.querySelector('.car-details h1').textContent = "Choisissez le tarif qui vous convient"; // Modal header
          modal.querySelector('.car-details h2').textContent = `${brand} ${model}`; // Car details
          modal.querySelector('.car-details h2').style.margin = '15px 0'; // Apply margin
          modal.querySelector('.car-details img').src = image;
          modal.querySelector('.car-details img').alt = `${brand} ${model}`;

          // Update "Payer en agence" section
          modal.querySelector('.option .price').textContent = `${dayPrice.toFixed(2)} € / jour`;
          modal.querySelector('.option .total').textContent = `TOTAL ${totalPerDay.toFixed(2)} €`;

          // Update "Payer en ligne" section
          modal.querySelector('.option.online .price').textContent = `${onlineDayPrice.toFixed(2)} € / jour`;
          modal.querySelector('.option.online .total').textContent = `TOTAL ${onlineTotal.toFixed(2)} €`;

          // Display the modal
          modal.style.display = 'block';
      });
  });

  // Close functionality for the modal
  document.querySelectorAll('.close-selectionner').forEach(closeButton => {
      closeButton.addEventListener('click', function() {
          this.closest('.modal-select').style.display = 'none';
      });
  });
});

document.addEventListener('DOMContentLoaded', function() {
  // Select all 'Sélectionner' buttons within the modal
  const selectButtons = document.querySelectorAll('.modal-select .option button');

  selectButtons.forEach(button => {
      button.addEventListener('click', function() {
          // Redirect the user to the login page
          window.location.href = '/login';
      });
  });
});
