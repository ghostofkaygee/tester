document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize sliders
    function initSliders(sliderClass) {
        const sliders = document.querySelectorAll(sliderClass);

        sliders.forEach(slider => {
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // Adjust scrolling speed
                slider.scrollLeft = scrollLeft - walk;
            });

            // Touch events for mobile
            slider.addEventListener('touchstart', (e) => {
                isDown = true;
                startX = e.touches[0].pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('touchend', () => {
                isDown = false;
            });

            slider.addEventListener('touchmove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.touches[0].pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // Adjust scrolling speed
                slider.scrollLeft = scrollLeft - walk;
            });
        });
    }

    // Initialize sliders
    initSliders('.accounts-slider');
    initSliders('.transactions-slider');
    initSliders('.deposits-slider');
});
