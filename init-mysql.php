<?php

$host = '127.0.0.1';
$dbName = 'record';
$dbUser = 'user_record';
$charset = 'utf8mb4';
$dbPassword = 'Pass*001';

$dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";

$pdo = null;

try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo 'connection failed0'. $exception->getMessage();
}

$pdo->exec('DROP TABLE IF EXISTS record;');
$pdo->exec('CREATE TABLE `record` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
 `author` varchar(128)  NOT NULL,
 `genre` varchar (64) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

$pdo->exec('INSERT INTO record
    (name, author, genre) VALUES
    ("Blood Sugar", "Pendulum", "Drum&Bass")'
);

$pdo->exec('INSERT INTO record
    (name, author, genre) VALUES
    ("We Got To Try", "The Chemical Brothers", "Electronica")'
);

$pdo->exec('INSERT INTO record
    (name, author, genre) VALUES
    ("Tsunamy", "Dusty Kid", "Electro")'
);

$pdo->exec('INSERT INTO record
    (name, author, genre) VALUES
    ("The Captain", "Johnica", "House")'
);

$pdo->exec('INSERT INTO record
    (name, author, genre) VALUES
    ("Adagio For Strings", "Tiesto", "Trance")'
);