document.addEventListener('DOMContentLoaded', function() {
    const countdownElement = document.getElementById('countdown');
    const daysElement = document.getElementById('days');
    const hoursElement = document.getElementById('hours');
    const minutesElement = document.getElementById('minutes');
    const secondsElement = document.getElementById('seconds');
    const subscribeForm = document.getElementById('subscribeForm');
    const subscribeMessage = document.getElementById('subscribeMessage');

    // Set the target countdown date (replace with your launch date)
    const targetDate = new Date('2025-05-15').getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const difference = targetDate - now;

        if (difference < 0) {
            clearInterval(countdownInterval);
            countdownElement.innerHTML = '<span class="text-success">Our Website is Live!</span>';
            return;
        }

        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        daysElement.textContent = String(days).padStart(2, '0');
        hoursElement.textContent = String(hours).padStart(2, '0');
        minutesElement.textContent = String(minutes).padStart(2, '0');
        secondsElement.textContent = String(seconds).padStart(2, '0');
    }

    const countdownInterval = setInterval(updateCountdown, 1000);
});
