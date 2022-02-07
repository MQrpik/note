<?php

declare(strict_types=1);

namespace App\Model;
use App\Exception\ConfigurationException;
//use App\Exception\NotFoundException;
use App\Exception\StorageExpection;
use PDO;
use PDOException;
//use Throwable;

abstract class AbstractModel 
{
public PDO $conn;

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        }   catch (PDOException $e) {
            throw new StorageExpection('Connection error');
        }
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn, 
            $config['user'], 
            $config['password'],
            [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
           );  // pmaietaj ze tworzysz w namespace App a odwolujesz sie do klasy globalnej  wiec tzreba bylo dodać \ albo zadeklarowac import klasy " use PDO; " i wtedy bez \.
    }

    private function validateConfig(array $config): void
    {
        if (
                empty($config['database'])
                || empty($config['host'])
                || empty($config['user'])
                || empty($config['password'])
                ){
                    throw new ConfigurationException('Error database configuration');
            }
    }

}



