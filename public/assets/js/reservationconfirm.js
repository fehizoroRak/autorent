function toggleAccordion(element) {
    const icon = element.querySelector('i');
    const content = element.nextElementSibling;
    if (content.style.display === "block") {
        content.style.display = "none";
        icon.className = 'ri-arrow-down-s-line';
    } else {
        content.style.display = "block";
        icon.className = 'ri-arrow-up-s-line';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const privacyPolicyCheckbox = document.getElementById('privacy-policy');
    const termsConditionsCheckbox = document.getElementById('terms-conditions');
    const submitButton = document.getElementById('submit-button');
    const errorMessage = document.getElementById('error-message');
    const reservationForm = document.getElementById('reservation-form');

    function validateForm(event) {
        if (!privacyPolicyCheckbox.checked || !termsConditionsCheckbox.checked) {
            event.preventDefault();
            errorMessage.style.display = 'block';
            if (!privacyPolicyCheckbox.checked) {
                privacyPolicyCheckbox.classList.add('error');
            }
            if (!termsConditionsCheckbox.checked) {
                termsConditionsCheckbox.classList.add('error');
            }
        }
    }

    submitButton.addEventListener('click', validateForm);

    privacyPolicyCheckbox.addEventListener('change', function() {
        privacyPolicyCheckbox.classList.remove('error');
        errorMessage.style.display = 'none';
    });

    termsConditionsCheckbox.addEventListener('change', function() {
        termsConditionsCheckbox.classList.remove('error');
        errorMessage.style.display = 'none';
    });
});