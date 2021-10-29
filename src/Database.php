<?php

declare(strict_types=1);

namespace App;

require_once("Exception/StorageException.php");
require_once("Exception/ConfigurationException.php");
require_once("Exception/NotFoundException.php");

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
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

    public function getNotes(): array 
    {
        try{
            $notes = [];
            $query = "SELECT id, title, created FROM notes" ; 
            $result = $this->conn->query($query);
            $notes = $result->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się pobrac danych z notatek', 400,$e);
        } 
    }

    public function getNote(int $id): array 
    {
        try{
            $query = "SELECT * FROM notes WHERE id = $id"; 
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
       
        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się pobrać notatki', 400,$e);
        } 

        if (!$note) { 
            throw new NotFoundException("Notatka od id: $id nie istnieje");
        }
         return $note;
    }

    public function createNote(array $data): void 
    {
        try {
        
        $title = $this->conn->quote($data['title']);
        $description = $this->conn->quote($data['description']);
        $created = $this->conn->quote(date('Y-m-d H:i:s'));

        $query = "
            INSERT INTO notes(title, description, created) 
            VALUES($title, $description, $created)
            ";

        $this->conn->exec($query);

    }catch (Throwable $e) {
        throw new StorageExpection('Nie udało się stworzyć notatki', 400);
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