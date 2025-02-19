<?php
/** BASE URL */
define("ROOT", "http://localhost/buscacep");

/** DATABASE CONNECT */
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "buscacep",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * @param string $path
 * @return string
 */
function url(string $path): string
{
    if ($path) {
        return ROOT . "{$path}";
    }
    return ROOT;
}

/**
 * @param string $message
 * @param string $type
 * @return string
 */
function message(string $message, string $type): string
{
    return "<div class=\"message {$type}\">{$message}</div>";
}