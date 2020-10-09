<?php

$database_config = array(
  'database_type' => 'mysql',
  'database_name' => 'bike',
  'server' => 'localhost',
  'username' => 'root',
  'password' => '',
);

$login_config = [
  'hash_algorithm' => 'sha256'
];

$jwt_config = array(
  'signing' =>
  array(
    'algorithm' => 'HS256',
    'key' => 'dwVPqVXTjvNsZVEXPzM28eJoojqa36pgPd0FTnoB6CDls2RIADosML1MXQH9OIeAClOld1P6xalXYxlV9FBeDlo6tMpkxXKhp2gVL5AvQDKbTFJHu4TY1JOo8qtnerLD',
  ),
  'issuer' => 'localhost',
  'audience' => 'localhost',
  'expiration' => 7200,
);
