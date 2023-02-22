<?php
    define('SERVER', "127.0.0.1:9000");

    define('DB1', "sportsdb");
    define('USER1', "root");
    define('PASS1', "");

    define('SGDB1', "mysql:host=".SERVER.";dbname=".DB1);

    define('METHOD', 'AES-256-CBC');
    define('SECRET_KEY', 'S3cr3t');
    define('SECRET_IV', '123456');