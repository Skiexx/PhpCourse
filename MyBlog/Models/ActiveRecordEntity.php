<?php

namespace Models;
use Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

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

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $mappedProperties[$this->camelCaseToUnderscore($propertyName)] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);
        $columns = [];
        $values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = $columnName;
            $values[':' . $columnName] = $value;
        }
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', array_keys($values)) . ')';
        $db = Db::getInstance();
        $db->execQuery($sql, $values);
    }

    private function update(array $mappedProperties): void
    {
        $columns = [];
        $values = [];
        foreach ($mappedProperties as $columnName => $value) {
            $values[':' . $columnName] = $value;
            if ($columnName === 'id') {
                continue;
            }
            $columns[] = $columnName . '=:' . $columnName;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns) . ' WHERE id=:id';
        $db = Db::getInstance();
        $db->execQuery($sql, $values);
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->execQuery(
            'DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->execQuery('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    abstract protected static function getTableName(): string;

    public static function getById(int $id): ?static
    {
        $db = Db::getInstance();
        $entities = $db->execQuery(
            'SELECT * FROM ' . static::getTableName() . ' WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public static function findOneByColumn(string $columnName, $value): ?static
    {
        $db = Db::getInstance();
        $entities = $db->execQuery(
            'SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName . '=:value;',
            [':value' => $value],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public static function getLatest(): ?static
    {
        $db = Db::getInstance();
        $entities = $db->execQuery(
            'SELECT * FROM ' . static::getTableName() . ' ORDER BY id DESC LIMIT 1;',
            [],
            static::class
        );
        return $entities ? $entities[0] : null;
    }
}