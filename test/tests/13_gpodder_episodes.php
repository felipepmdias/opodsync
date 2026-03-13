<?php

use KD2\HTTP;
use KD2\Test;

$data = json_decode(file_get_contents(__DIR__ . '/../episodes.json'), true);

$r = $http->POST('/api/2/episodes/demo.json', $data, HTTP::JSON);
Test::equals(200, $r->status, $r);

$oauth_action = [
	[
		'action' => 'play',
		'episode' => 'http://example.net/files/no-device.ogg',
		'podcast' => 'http://example.com/feed.rss',
		'device' => '',
		'position' => 1,
	],
];
$r = $http->POST('/api/2/episodes/demo.json', $oauth_action, HTTP::JSON);
Test::equals(200, $r->status, $r);

$r = $http->GET('/api/2/episodes/demo.json');
Test::equals(200, $r->status, $r);

$r = json_decode($r->body);
Test::assert(is_object($r));
Test::assert(isset($r->actions));
Test::assert(count($r->actions) === 3);

$found = false;
foreach ($r->actions as $a) {
	if ($a->episode === 'http://example.net/files/no-device.ogg') {
		$found = true;
		Test::assert(!property_exists($a, 'device'));
	}
}
Test::assert($found);

$r = $http->GET('/api/2/episodes/demo.json?action=download');
Test::equals(200, $r->status, $r);
$r = json_decode($r->body);
Test::assert(is_object($r));
Test::assert(isset($r->actions));
Test::assert(count($r->actions) === 1);
Test::equals('download', $r->actions[0]->action);

$r = $http->GET('/api/2/episodes/demo.json?action=play&podcast=http%3A%2F%2Fexample.org%2Fpodcast.php');
Test::equals(200, $r->status, $r);
$r = json_decode($r->body);
Test::assert(is_object($r));
Test::assert(isset($r->actions));
Test::assert(count($r->actions) === 1);
Test::equals('play', $r->actions[0]->action);

$db = new SQLite3($data_root . '/data.sqlite');
$res = $db->query('SELECT a.device, d.deviceid, a.user, d.user AS device_user
	FROM episodes_actions a
	LEFT JOIN devices d ON d.id = a.device
	ORDER BY a.id;');
$rows = [];

while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
	$rows[] = $row;
}

Test::assert(count($rows) === 3);

foreach ($rows as $row) {
	if (!empty($row['device'])) {
		Test::equals('test-device', $row['deviceid']);
		Test::equals($row['user'], $row['device_user']);
	}
	else {
		Test::assert($row['deviceid'] === null);
		Test::assert($row['device_user'] === null);
	}
}
