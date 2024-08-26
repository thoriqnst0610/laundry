<?php

namespace laundry\Repository;

use Exception;
use laundry\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {

        try {

            $statement = $this->connection->prepare("INSERT INTO users(id, name, password, verification_code) VALUES (?, ?, ?, ?)");
            $statement->execute([
                $user->id, $user->name, $user->password, $user->verification_code
            ]);
            return $user;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function update(User $user): User
    {

        try {

            $statement = $this->connection->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
            $statement->execute([
                $user->name, $user->password, $user->id
            ]);
            return $user;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function findById(string $id): ?User
    {


        try {

            $statement = $this->connection->prepare("SELECT id, name, password, is_verified FROM users WHERE id = ?");
            $statement->execute([$id]);

            if ($row = $statement->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->password = $row['password'];
                $user->is_verified = $row['is_verified'];
                return $user;
            } else {

                return null;
            }
            
        }catch(Exception $ex){

            throw $ex;

        } finally {

            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        try {

            $this->connection->exec("DELETE from users");
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function verifikasi(string $verifikasi): void
    {

        try {

            $statement = $this->connection->prepare("UPDATE users SET is_verified = ? WHERE verification_code = ? AND is_verified = ?");
            $statement->execute([1, $verifikasi, 0]);

        } catch (Exception $ex) {

            throw $ex;
            
        }
    }
}
