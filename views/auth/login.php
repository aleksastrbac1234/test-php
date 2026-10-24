<h1>Login</h1>

<form method="POST" action="/login" class="form">
    <?= csrf_field() ?>

    <?php if (isset($error)): ?>
        <p class="error"><?= e($error) ?></p>
    <?php endif; ?>

    <label>Email
        <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>">
    </label>

    <label>Password
        <input type="password" name="password">
    </label>

    <button type="submit">Log in</button>
</form>

<p>Don't have an account? <a href="/register">Register</a></p>