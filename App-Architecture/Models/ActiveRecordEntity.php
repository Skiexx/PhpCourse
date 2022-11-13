<?php

namespace Models;
use Services\Db;

abstract class ActiveRecordEntity
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->execQuery('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    abstract protected static function getTableName(): string;

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->execQuery(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }
}