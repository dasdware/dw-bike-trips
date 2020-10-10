<?php

$database_config = array(
  'database_type' => 'mysql',
  'database_name' => 'bike',
  'server' => 'localhost',
  'username' => 'root',
  'password' => '',
);

$login_config = array(
  'hash_algorithm' => 'sha256'
);

$jwt_config = array(
  'signing' =>
  array(
    'algorithm' => 'HS256',
    'key' => 'PfQJgv8Zb5XkUHZpYhLPHMURzhJoMCjgcvNQpH3is0tYsPXuFZpMaWpUIqbjVq5aKCLjJ7nlM15h6OozW067dzT6WT9qDcKstRjpJQnOradxn1Ue9W3TBgmfNdCdKKKB',
  ),
  'issuer' => 'localhost',
  'audience' => 'localhost',
  'expiration' => 7200,
);
