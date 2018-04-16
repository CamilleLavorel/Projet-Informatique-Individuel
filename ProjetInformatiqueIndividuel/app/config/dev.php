<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',  // Mandatory for PHPUnit testing
    'port'     => '3306',
    'dbname'   => 'experienceetranger',
    'user'     => 'experience_user',
    'password' => 'secret',
);

// enable the debug mode
$app['debug'] = true;