<?php

// Authentication
if (!array_key_exists('HTTP_X_TOKEN', $_SERVER)) {
    die;
}
$url = 'https://'.$_SERVER['HTTP_HOST'].'/auth:';
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER , [
    "X-Token: {$_SERVER['HTTP_X_TOKEN']}"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);

if (curl_errno($ch) != 0)
    die(curl_error($ch).PHP_EOL);
if ($res !== 'true') {
    http_response_code(403);
    die;
}
/* if (
    !array_key_exists('HTTP_X_HASH', $_SERVER) ||
    !array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) ||
    !array_key_exists('HTTP_X_UID', $_SERVER)
) die;
list($hash, $timestamp, $uid) = array(
    $_SERVER['HTTP_X_HASH'],
    $_SERVER['HTTP_X_TIMESTAMP'],
    $_SERVER['HTTP_X_UID']
);
$secret = '01234567';
$newHash = sha1($uid.$timestamp.$secret);
if ($newHash !== $hash)
    die; */

// Define valid resource types
$allowedResourceType = [
    'books',
    'authors',
    'genres'
];

// Get resource and check
$resourceType = $_GET['resource_type'];
if ( !in_array($resourceType, $allowedResourceType) ) {
    die;
}

// Define resources
$books = [
    1 => [
        'title' => 'The art of war',
        'author_id' => 2,
        'genre_id' => 2
    ],
    2 => [
        'title' => 'The Iliad',
        'author_id' => 1,
        'genre_id' => 1
    ],
    3 => [
        'title' => 'War and peace',
        'author_id' => 3,
        'genre_id' => 1
    ]
];

// Notify client that json will be used
header('Content-type: application/json');
// Get resource id
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';
// Get http action and generate response
$method = $_SERVER['REQUEST_METHOD'];
switch (strtoupper($method)) {
    case 'GET':
        if ( !empty($resourceId) ) {
            if (array_key_exists($resourceId, $books)) {
                echo json_encode($books[$resourceId]);
            } else {
                die;
            }
        } else {
            echo json_encode($books);
        }
        echo PHP_EOL;
        break;
    case 'POST':
        $json = file_get_contents('php://input');
        $books[] = json_decode($json);
        echo array_keys($books)[count($books-1)].PHP_EOL;
        break;
    case 'PUT':
        if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
            $json = file_get_contents('php://input');
            $books[$resourceId] = json_decode($json, true);
            echo $resourceId.PHP_EOL;
        }
        break;
    case 'DELETE':
        if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
            unset($books[$resourceId]);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode([
            'error' => $method.' not yet implemented...'
        ]);
        break;
}
