document.addEventListener('DOMContentLoaded', function () {

    const directionBtn =
        document.getElementById('googleDirectionBtn');

    const uberBtn =
        document.getElementById('uberRideBtn');

    if (directionBtn) {

        directionBtn.addEventListener('click', function () {

            const url =
                `https://www.google.com/maps/dir/?api=1&destination=${hospitalLocation.latitude},${hospitalLocation.longitude}`;

            window.open(url, '_blank');
        });
    }

    if (uberBtn) {

        uberBtn.addEventListener('click', function () {

            const uberUrl =
                `https://m.uber.com/ul/?action=setPickup&dropoff[latitude]=${hospitalLocation.latitude}&dropoff[longitude]=${hospitalLocation.longitude}&dropoff[nickname]=${encodeURIComponent(hospitalLocation.name)}`;

            window.open(uberUrl, '_blank');
        });
    }

});

