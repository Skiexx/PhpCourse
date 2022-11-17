<?php

namespace Services;
use Exceptions\DbException;
use PDO;

class Db {
    static ?Db $instance = null;

    private PDO $pdo;

    /**
     * Db constructor.
     * @throws DbException
     */
    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../settings.php')['db'];

        try {
            $this->pdo = new PDO(
                'pgsql:host=' . $dbOptions['host'] .
                ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']);
        } catch (\PDOException $e) {
            throw new \Exceptions\DbException('Ошибка подключения к базе данных: ' . $e->getMessage());
        }
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