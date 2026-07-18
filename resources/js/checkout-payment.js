export function initCheckoutPayment() {
    const form = document.getElementById('checkout-form');
    const overlay = document.getElementById('payment-loading-overlay');

    if (!form || !overlay) return;

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) submitButton.disabled = true;

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        const minDelay = new Promise((resolve) => setTimeout(resolve, 1400));

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                throw new Error('Checkout request failed');
            }

            const data = await response.json();

            if (!data.redirect_url) {
                throw new Error('No redirect URL returned');
            }

            await minDelay;
            window.location.href = data.redirect_url;
        } catch (error) {
            // Fall back to a normal form submission so validation errors,
            // stock issues, or a misconfigured gateway render the usual way.
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            if (submitButton) submitButton.disabled = false;
            form.submit();
        }
    });
}
