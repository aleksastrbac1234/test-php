
<h1>Reports</h1>

<form method="GET" action="/reports" class="filters">
    <label>From
        <input type="date" name="date_from" value="<?= e($from) ?>">
    </label>

    <label>To
        <input type="date" name="date_to" value="<?= e($to) ?>">
    </label>

    <button type="submit" class="button">Show</button>
    <a href="/reports">Last 30 days</a>
</form>

<div class="chart-box">
    <canvas id="report-chart"></canvas>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Date</th>
        <th>Page A views</th>
        <th>Page B views</th>
        <th>"Buy a cow" clicks</th>
        <th>"Download" clicks</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= e($row['date']) ?></td>
            <td><?= $row['page_a_views'] ?></td>
            <td><?= $row['page_b_views'] ?></td>
            <td><?= $row['buy_cow_clicks'] ?></td>
            <td><?= $row['download_clicks'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const rows = <?= json_encode($rows) ?>;

    const series = [
        { label: 'Page A views', key: 'page_a_views', color: '#2f6b4f' },
        { label: 'Page B views', key: 'page_b_views', color: '#3b6fb6' },
        { label: '"Buy a cow" clicks', key: 'buy_cow_clicks', color: '#c9822b' },
        { label: '"Download" clicks', key: 'download_clicks', color: '#b3261e' },
    ];

    new Chart(document.getElementById('report-chart'), {
        type: rows.length === 1 ? 'bar' : 'line',
        data: {
            labels: rows.map(row => row.date),
            datasets: series.map(item => ({
                label: item.label,
                data: rows.map(row => row[item.key]),
                borderColor: item.color,
                backgroundColor: item.color,
                pointRadius: 4,
            })),
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
            },
        },
    });
</script>