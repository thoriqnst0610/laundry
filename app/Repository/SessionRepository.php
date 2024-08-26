<?php

namespace laundry\Repository;

use Exception;
use laundry\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        try {

            $statement = $this->connection->prepare("INSERT INTO sessions(id, user_id) VALUES (?, ?)");
            $statement->execute([$session->id, $session->userId]);
            return $session;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function findById(string $id): ?Session
    {


        try {

            $statement = $this->connection->prepare("SELECT id, user_id from sessions WHERE id = ?");
            $statement->execute([$id]);

            if ($row = $statement->fetch()) {
                $session = new Session();
                $session->id = $row['id'];
                $session->userId = $row['user_id'];
                return $session;
            } else {
                return null;
            }

        }catch(Exception $ex){

            throw $ex;

        } finally {

            $statement->closeCursor();
            
        }
    }

    public function deleteById(string $id): void
    {

        try {

            $statement = $this->connection->prepare("DELETE FROM sessions WHERE id = ?");
            $statement->execute([$id]);
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function deleteAll(): void
    {

        try {

            $this->connection->exec("DELETE FROM sessions");
        } catch (Exception $ex) {

            throw $ex;
        }
    }
}
