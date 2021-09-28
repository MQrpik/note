<?php

declare(strict_types=1);

namespace App;

require_once("Exception/StorageException.php");
require_once("Exception/ConfigurationException.php");

use App\Exception\ConfigurationException;
use App\Exception\StorageExpection;
use PDO;
use PDOException;
use Throwable;

class Database 
{
    private PDO $conn;

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        }   catch (PDOException $e) {
            throw new StorageExpection('Connection error');
        }
    }

    public function createNote(array $data): void 
    {
        try {
        echo "pusto pusto";
        
        $title = $data['title'];
        $description = $data['description'];
        $created = date('Y-m-d H:i:s');

        $query = "
            INSERT INTO notes(title, description, created) 
            VALUES('$title', '$description', '$created')
            ";

        $this->conn->exec($query);

    }catch (Throwable $e) {
        dump($e);
        exit;
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