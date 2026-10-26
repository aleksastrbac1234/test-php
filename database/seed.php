<?php

require __DIR__ . '/../src/bootstrap.php';

use App\Core\Database;

$db = Database::get();

$db->exec('DELETE FROM events');
$db->exec('DELETE FROM users');

$users = [
    ['Admin', 'admin@example.com', 'admin'],
    ['John Smith', 'john@example.com', 'user'],
    ['Emma Brown', 'emma@example.com', 'user'],
    ['Luka Petrovic', 'luka@example.com', 'user'],
];

$insertUser = $db->prepare('INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, ?)');
$insertEvent = $db->prepare('INSERT INTO events (user_id, action, target, ip, created_at) VALUES (?, ?, ?, ?, ?)');

$password = password_hash('password', PASSWORD_DEFAULT);
$registeredAt = date('Y-m-d H:i:s', strtotime('-31 days 09:00'));
$eventCount = 0;

$db->beginTransaction();

foreach ($users as [$name, $email, $role]) {
    $insertUser->execute([$name, $email, $password, $role, $registeredAt]);
    $userId = (int) $db->lastInsertId();

    $insertEvent->execute([$userId, 'registration', null, '127.0.0.1', $registeredAt]);
    $eventCount++;

    for ($day = 30; $day >= 1; $day--) {
        if (mt_rand(1, 10) > 7) {
            continue;
        }

        $date = date('Y-m-d', strtotime("-$day days"));
        $time = strtotime("$date 08:00") + mt_rand(0, 10 * 3600);

        $events = [['login', null]];

        for ($i = 0; $i < mt_rand(2, 8); $i++) {
            if (mt_rand(0, 1)) {
                $events[] = ['view_page', 'page_a'];

                if (mt_rand(1, 10) <= 4) {
                    $events[] = ['button_click', 'buy_cow'];
                }
            } else {
                $events[] = ['view_page', 'page_b'];

                if (mt_rand(1, 10) <= 3) {
                    $events[] = ['button_click', 'download'];
                }
            }
        }

        $events[] = ['logout', null];

        foreach ($events as [$action, $target]) {
            $time += mt_rand(10, 300);
            $insertEvent->execute([$userId, $action, $target, '127.0.0.1', date('Y-m-d H:i:s', $time)]);
            $eventCount++;
        }
    }
}

$db->commit();

echo 'Seeded ' . count($users) . " users and $eventCount events.\n";
echo "Admin: admin@example.com / password\n";
echo "User:  john@example.com / password\n";