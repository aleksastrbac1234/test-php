<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activity Tracker</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav>
    <a href="/" class="logo">Activity Tracker</a>
    <div class="nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/page-a">Page A</a>
            <a href="/page-b">Page B</a>
            <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                <a href="/statistics">Statistics</a>
                <a href="/reports">Reports</a>
            <?php endif; ?>
            <span><?= e($_SESSION['user_name'] ?? '') ?></span>
            <form method="POST" action="/logout">
                <?= csrf_field() ?>
                <button type="submit" class="link-button">Logout</button>
            </form>
        <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php endif; ?>
    </div>
</nav>

<main>
    <?php if ($message = get_flash()): ?>
        <p class="flash"><?= e($message) ?></p>
    <?php endif; ?>

    <?= $content ?>
</main>
</body>
</html>