<?php

declare(strict_types=1);

namespace App\Model;

//use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageExpection;
use PDO;
//use PDOException;
use Throwable;

class Database  extends AbstractModel
{
    public function serchNotes (string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder) : array
    {
        try{
            $limit = $pageSize;
            $offset = ($pageNumber -1) * $pageSize;
            
            if (!in_array($sortBy, ['created', 'title'] )) {
                $sortBy = 'title';
            }
            if (!in_array($sortOrder, ['desc', 'asc'] )) {
                $sortBy = 'desc';
            }

            $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);

            $query = "
                    SELECT id, title, created 
                    FROM notes
                    WHERE title LIKE ($phrase)
                    ORDER BY $sortBy $sortOrder
                    LIMIT $offset, $limit
                    " ; 
            $result = $this->conn->query($query);
            $notes = $result->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się wyszukać notatek', 400,$e);
        } 
    }

    public function getSearchCount(string $phrase) : int
    {
        try{
            $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
            $query = "SELECT count(*) AS cn FROM notes WHERE title LIKE ($phrase)"; 
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageExpection('Bład przy pobieraniu ilości rekordow z bazy', 400);
            }
            return (int) $result['cn'];
        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się pobrac ilości notatek', 400,$e);
        } 
    }
    public function getNotes(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array 
    {
        try{
            $limit = $pageSize;
            $offset = ($pageNumber -1) * $pageSize;

            if (!in_array($sortBy, ['created', 'title'] )) {
                $sortBy = 'title';
            }
            if (!in_array($sortOrder, ['desc', 'asc'] )) {
                $sortBy = 'desc';
            }

            $notes = [];
            $query = "
                    SELECT id, title, created 
                    FROM notes
                    ORDER BY $sortBy $sortOrder
                    LIMIT $offset, $limit
                    " ; 
            $result = $this->conn->query($query);
            $notes = $result->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się pobrac danych z notatek', 400,$e);
        } 
    }

    public function getCount(): int
    {
        try{
            $query = "SELECT count(*) AS cn FROM notes"; 
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageExpection('Bład przy pobieraniu ilości rekordow z bazy', 400);
                //return (int) $result ['cn'];
            }
            return (int) $result['cn'];
        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się pobrac ilości notatek', 400,$e);
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

    public function editNote(int $id, array $data): void {
        try{
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
        
            $query = "
            UPDATE notes
            SET title = $title, description = $description
            WHERE id = $id
            ";

        $this->conn->exec($query);

        } catch (Throwable $e) {
            throw new StorageExpection('Nie udało się zaktualizować notatki', 400, $e);
        }
    }

    public function deleteNote(int $id): void {
        try {
        $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
        $this->conn->exec($query);

    } catch (Throwable $e) {
        throw new StorageExpection('Nie udało się usunąć notatki', 400, $e);
    }
    }

    
}