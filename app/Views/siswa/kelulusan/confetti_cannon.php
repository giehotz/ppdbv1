<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script>
(function () {
    function launchConfetti() {
        if (typeof confetti !== 'function') {
            return;
        }

        const duration = 3200;
        const end = Date.now() + duration;

        (function frame() {
            confetti({
                particleCount: 3,
                angle: 60,
                spread: 80,
                startVelocity: 50,
                origin: { x: 0, y: 0.65 },
                colors: ['#10b981', '#a7f3d0', '#ffffff', '#065f46'],
                scalar: 1.1,
                ticks: 200
            });

            confetti({
                particleCount: 3,
                angle: 120,
                spread: 80,
                startVelocity: 50,
                origin: { x: 1, y: 0.65 },
                colors: ['#16a34a', '#86efac', '#ffffff', '#064e3b'],
                scalar: 1.1,
                ticks: 200
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        }());

        confetti({
            particleCount: 150,
            spread: 160,
            startVelocity: 45,
            decay: 0.92,
            origin: { x: 0.5, y: 0.75 },
            scalar: 1.2,
            colors: ['#16a34a', '#86efac', '#fbbf24', '#ffffff', '#065f46'],
            ticks: 280
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', launchConfetti);
    } else {
        launchConfetti();
    }
}());
</script>
