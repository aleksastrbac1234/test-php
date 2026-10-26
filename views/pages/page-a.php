<h1>Page A</h1>

<form id="buy-cow-form" method="POST" action="/buy-cow">
    <?= csrf_field() ?>
    <button type="submit" class="button">Buy a cow</button>
</form>

<p id="thank-you" hidden>thankYou</p>

<script>
    const form = document.getElementById('buy-cow-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
        });

        if (response.ok) {
            form.remove();
            document.getElementById('thank-you').hidden = false;
        }
    });
</script>