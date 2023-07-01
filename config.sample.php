<?php

$server_config = [
  'name' => '<server name>'
];

$database_config = [
  'database_type' => '<database type>',
  'database_name' => '<database name>',
  'server' => '<database server>',
  'username' => '<database user>',
  'password' => '<database user password>',
];

$login_config = [
  'hash_algorithm' => 'sha256'
];

$jwt_config = [
  'signing' =>  [
    'algorithm' => 'HS256',
    'key' => '<jwt signing key>',
  ],
  'issuer' => 'dw-bike-trips-api',
  'audience' => 'dw-bike-trips-client',
  'expiration' => 7200,
];
