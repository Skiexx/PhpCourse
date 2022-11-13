<?php

namespace Services;
use PDO;

class Db {
    static ?Db $instance = null;

    private PDO $pdo;

    /**
     * Db constructor.
     */
    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../settings.php')['db'];

        $this->pdo = new PDO(
            'pgsql:host=' . $dbOptions['host'] .
            ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']);
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    public function execQuery(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        return $result ? $sth->fetchAll(PDO::FETCH_CLASS, $className) : null;
    }
}