<h1>Statistics</h1>

<form method="GET" action="/statistics" class="filters">
    <label>From
        <input type="date" name="date_from" value="<?= e($filters['date_from']) ?>">
    </label>

    <label>To
        <input type="date" name="date_to" value="<?= e($filters['date_to']) ?>">
    </label>

    <label>User
        <select name="user_id">
            <option value="">All users</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>" <?= $filters['user_id'] === $user['id'] ? 'selected' : '' ?>>
                    <?= e($user['name']) ?> (<?= e($user['email']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Action
        <select name="action">
            <option value="">All actions</option>
            <?php foreach ($actions as $action): ?>
                <option value="<?= $action ?>" <?= $filters['action'] === $action ? 'selected' : '' ?>>
                    <?= $action ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit" class="button">Filter</button>
    <a href="/statistics">Reset</a>
</form>

<p><?= $total ?> events found</p>

<table class="table">
    <thead>
    <tr>
        <th>Date</th>
        <th>User</th>
        <th>Action</th>
        <th>Target</th>
        <th>IP</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($events as $event): ?>
        <tr>
            <td><?= e($event['created_at']) ?></td>
            <td><?= e($event['user_name'] ?? '-') ?></td>
            <td><?= e($event['action']) ?></td>
            <td><?= e($event['target'] ?? '') ?></td>
            <td><?= e($event['ip'] ?? '') ?></td>
        </tr>
    <?php endforeach; ?>

    <?php if (!$events): ?>
        <tr>
            <td colspan="5">No events found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php if ($pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="/statistics?<?= http_build_query(array_filter($filters) + ['page' => $page - 1]) ?>">Previous</a>
        <?php endif; ?>

        <span>Page <?= $page ?> of <?= $pages ?></span>

        <?php if ($page < $pages): ?>
            <a href="/statistics?<?= http_build_query(array_filter($filters) + ['page' => $page + 1]) ?>">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>