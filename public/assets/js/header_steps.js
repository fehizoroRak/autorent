
    document.addEventListener('DOMContentLoaded', function () {
        const steps = document.querySelectorAll('.step-1, .step-2, .step-3, .step-4');
        const stepDetails = document.querySelectorAll('.step-details, .step-details2, .step-details3, .step-details4');
        const header = document.getElementById('header');

        window.addEventListener('scroll', function () {
            let scrollTop = window.scrollY;

            if (scrollTop > 100) {
                stepDetails.forEach((detail) => {
                    detail.style.transition = 'opacity 0.5s ease, height 0.5s ease';
                    detail.style.opacity = '0';
                    detail.style.height = '0';
                });

                steps.forEach((step) => {
                    step.style.transition = 'height 0.5s ease';
                    step.style.height = '48px';
                });

                header.style.transition = 'height 0.5s ease';
                header.style.height = 'auto'; // Ajustez si besoin la hauteur du header
            } else {
                stepDetails.forEach((detail) => {
                    detail.style.transition = 'opacity 0.5s ease, height 0.5s ease';
                    detail.style.opacity = '1';
                    detail.style.height = 'auto'; // Remet la hauteur automatique
                });

                steps.forEach((step) => {
                    step.style.transition = 'height 0.5s ease';
                    step.style.height = 'auto'; // Remet la hauteur originale
                });

                header.style.transition = 'height 0.5s ease';
                header.style.height = 'auto';
            }
        });
    });
