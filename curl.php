<?php

$data = [
    'username' => 'ubuntu',
    'password' => '01234567'
];
$payload = json_encode($data);

$ch = curl_init('https://api.example.com/api/1.0/user/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length'.strlen($payload)
]);

$res = curl_exec($ch);
curl_close($ch);
