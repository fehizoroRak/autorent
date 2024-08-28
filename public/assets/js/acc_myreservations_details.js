document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab');
    const paymentModeInput = document.getElementById('payment_mode');
    const paymentMethods = document.querySelectorAll('.payment-method');

    // Gestion des onglets pour changer le mode de paiement
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            paymentMethods.forEach(method => method.style.display = 'none');

            const selectedMethod = tab.getAttribute('data-tab');
            document.getElementById(selectedMethod).style.display = 'block';

            paymentModeInput.value = selectedMethod;
        });
    });
});

function processPayment() {
    // Valider le formulaire
    if (!validateForm()) {
        return false;
    }

    // Masquer le formulaire et afficher le spinner de chargement
    document.getElementById('payment-form').style.display = 'none';
    document.getElementById('loading-spinner').style.display = 'flex';

    // Simuler un délai pour le processus de paiement
    setTimeout(function () {
        // Afficher le message de succès
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('success-message').style.display = 'flex';

        // Soumettre le formulaire après avoir affiché le message de succès
        setTimeout(function () {
            document.getElementById('payment-form').submit();
        }, 2000);
    }, 2000);

    // Empêcher la soumission immédiate du formulaire
    return false;
}

function validateForm() {
    let isValid = true;

    // Effacer les messages d'erreur précédents et réinitialiser les bordures
    document.querySelectorAll('.error-message').forEach(function (element) {
        element.textContent = '';
    });
    document.querySelectorAll('input').forEach(function (input) {
        input.style.border = '';
    });

    // Validation du formulaire de carte de crédit
    if (document.getElementById('payment_mode').value === 'credit-card') {
        if (!document.getElementById('card-number').value) {
            document.getElementById('card-number-error').textContent = 'Le numéro de carte est requis';
            document.getElementById('card-number-error').style.color = 'red';
            document.getElementById('card-number').style.border = '2px solid red';
            isValid = false;
        }
        if (!document.getElementById('expiration-date').value) {
            document.getElementById('expiration-date-error').textContent = "La date d'expiration est requise";
            document.getElementById('expiration-date-error').style.color = 'red';
            document.getElementById('expiration-date').style.border = '2px solid red';
            isValid = false;
        }
        if (!document.getElementById('cvv').value) {
            document.getElementById('cvv-error').textContent = 'Le CVV est requis';
            document.getElementById('cvv-error').style.color = 'red';
            document.getElementById('cvv').style.border = '2px solid red';
            isValid = false;
        }
        if (!document.getElementById('cardholder-name').value) {
            document.getElementById('cardholder-name-error').textContent = 'Le nom du titulaire est requis';
            document.getElementById('cardholder-name-error').style.color = 'red';
            document.getElementById('cardholder-name').style.border = '2px solid red';
            isValid = false;
        }
    }

    // Validation du formulaire PayPal
    if (document.getElementById('payment_mode').value === 'paypal') {
        if (!document.getElementById('paypal-email').value) {
            document.getElementById('paypal-email-error').textContent = 'Email PayPal est requis';
            document.getElementById('paypal-email-error').style.color = 'red';
            document.getElementById('paypal-email').style.border = '2px solid red';
            isValid = false;
        }
        if (!document.getElementById('paypal-password').value) {
            document.getElementById('paypal-password-error').textContent = 'Mot de passe PayPal est requis';
            document.getElementById('paypal-password-error').style.color = 'red';
            document.getElementById('paypal-password').style.border = '2px solid red';
            isValid = false;
        }
    }

    // Validation du formulaire de virement bancaire
    if (document.getElementById('payment_mode').value === 'bank-transfer') {
        if (!document.getElementById('iban').value) {
            document.getElementById('iban-error').textContent = 'IBAN est requis';
            document.getElementById('iban-error').style.color = 'red';
            document.getElementById('iban').style.border = '2px solid red';
            isValid = false;
        }
        if (!document.getElementById('account-holder').value) {
            document.getElementById('account-holder-error').textContent = 'Le nom du titulaire du compte est requis';
            document.getElementById('account-holder-error').style.color = 'red';
            document.getElementById('account-holder').style.border = '2px solid red';
            isValid = false;
        }
        if (!document.getElementById('bank-name').value) {
            document.getElementById('bank-name-error').textContent = 'Le nom de la banque est requis';
            document.getElementById('bank-name-error').style.color = 'red';
            document.getElementById('bank-name').style.border = '2px solid red';
            isValid = false;
        }
    }

    // Retourner false pour empêcher la soumission du formulaire si la validation échoue
    return isValid;
}

function processAgencyPayment() {
    document.getElementById('confirm-agency-form').style.display = 'none';
    document.getElementById('loading-spinner').style.display = 'flex';

    // Simuler un délai pour le processus de confirmation de paiement
    setTimeout(function () {
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('success-message').style.display = 'flex';

        // Redirection après la confirmation
        setTimeout(function () {
            document.getElementById('confirm-agency-form').submit();
        }, 2000);
    }, 2000);

    return false;
}