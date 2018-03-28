(function() {
    var cities = {
        LT: ['Vilnius', 'Kaunas', 'Klaipeda', 'Other'],
        AF: ['Kabul', 'Other'],
        US: ['Los Angeles', 'Austin', 'Martinsville', 'Other']
    };

    var countryPicker = document.getElementById('country-picker');
    var cityPicker = document.getElementById('city-picker');

    countryPicker.addEventListener('change', function() {
        var initialCity = cityPicker.value;
        var allowed = cities[this.value];

        if (allowed == null) {
            allowed = ['Other'];
        }

        // Remove all options in the dropdown
        while (cityPicker.options.length) {
            cityPicker.options.remove(0);
        }

        // Add allowed options
        for (var i = 0 ; i < allowed.length ; i ++) {
            var city = new Option(allowed[i], allowed[i]);
            cityPicker.options.add(city);
        }

        // Reset initial city if possible
        cityPicker.value = initialCity;
    });

    // Trigger initial onchange to load cities of a selected country
    var evt = document.createEvent('HTMLEvents');
    evt.initEvent('change', false, true);
    countryPicker.dispatchEvent(evt);
})();