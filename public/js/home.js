document.addEventListener('DOMContentLoaded', function () {
    const pickupInput = document.getElementById('pickupLocation');
    const dropoffInput = document.getElementById('dropoffLocation');
    const pickupSuggestions = document.getElementById('pickupSuggestions');
    const dropoffSuggestions = document.getElementById('dropoffSuggestions');

    pickupInput.addEventListener('input', function () {
        fetchSuggestions(pickupInput.value, '/cities/pickup', pickupSuggestions);
    });

    dropoffInput.addEventListener('input', function () {
        fetchSuggestions(dropoffInput.value, '/cities/dropoff', dropoffSuggestions);
    });

    function fetchSuggestions(query, url, suggestionsContainer) {
        if (query.length === 0) {
            suggestionsContainer.innerHTML = '';
            return;
        }

        fetch(`${url}?q=${query}`)
            .then(response => response.json())
            .then(data => {
                suggestionsContainer.innerHTML = '';
                data.forEach(city => {
                    const div = document.createElement('div');
                    div.textContent = city.name;
                    div.addEventListener('click', () => {
                        if (url.includes('pickup')) {
                            pickupInput.value = city.name;
                        } else {
                            dropoffInput.value = city.name;
                        }
                        suggestionsContainer.innerHTML = '';
                    });
                    suggestionsContainer.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching suggestions:', error));
    }
});

