<?php

use KD2\HTTP;
use KD2\Test;

// account scope
$r = $http->GET('/api/2/settings/demo/account.json');
Test::equals(200, $r->status, $r);
Test::assert(json_decode($r->body, true) === []);

$r = $http->POST('/api/2/settings/demo/account.json', [
	'set' => [
		'setting1' => 'value1',
		'setting2' => 123,
		'setting3' => true,
	],
], HTTP::JSON);
Test::equals(200, $r->status, $r);
$data = json_decode($r->body, true);
Test::equals('value1', $data['setting1']);
Test::equals(123, $data['setting2']);
Test::equals(true, $data['setting3']);

$r = $http->POST('/api/2/settings/demo/account.json', [
	'remove' => ['setting2'],
], HTTP::JSON);
Test::equals(200, $r->status, $r);
$data = json_decode($r->body, true);
Test::assert(!array_key_exists('setting2', $data));

// device scope
$r = $http->GET('/api/2/settings/demo/device.json');
Test::equals(400, $r->status, $r);

$r = $http->POST('/api/2/settings/demo/device.json?device=test-device', [
	'set' => ['volume' => 0.75],
], HTTP::JSON);
Test::equals(200, $r->status, $r);
$data = json_decode($r->body, true);
Test::equals(0.75, $data['volume']);

// podcast scope
$podcast = 'https://example.com/feed.xml';
$r = $http->GET('/api/2/settings/demo/podcast.json');
Test::equals(400, $r->status, $r);

$r = $http->POST('/api/2/settings/demo/podcast.json?podcast=' . rawurlencode($podcast), [
	'set' => ['autodownload' => false],
], HTTP::JSON);
Test::equals(200, $r->status, $r);
$data = json_decode($r->body, true);
Test::equals(false, $data['autodownload']);

// episode scope
$episode = 'https://example.com/media.mp3';
$r = $http->GET('/api/2/settings/demo/episode.json?podcast=' . rawurlencode($podcast));
Test::equals(400, $r->status, $r);

$r = $http->POST('/api/2/settings/demo/episode.json?podcast=' . rawurlencode($podcast) . '&episode=' . rawurlencode($episode), [
	'set' => ['speed' => 1.25],
], HTTP::JSON);
Test::equals(200, $r->status, $r);
$data = json_decode($r->body, true);
Test::equals(1.25, $data['speed']);
