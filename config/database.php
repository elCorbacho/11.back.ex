<?php
class Database {
    private static $host = 'localhost';
    private static $db_name = 'todocamisetas_db';
    private static $username = 'root';
    private static $password = '';
    public static $conn;

    public static function connect() {
        if (!self::$conn) {
            self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}