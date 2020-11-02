<?php 
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class Database extends TestCase
{
    // Test database
    use TestCaseTrait;

    static private $pdo = null;
    private $conn = null;

    public static function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }
    
}
?>