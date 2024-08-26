<?php

namespace laundry\Repository;

use Exception;
use laundry\Domain\Pengaturan;
use PDO;

class pengaturanrepository
{

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function mengambil(): Pengaturan
    {

        try {

            $statement = $this->connection->prepare("SELECT * FROM pengaturan");
            $statement->execute([]);
            $response = $statement->fetchAll(PDO::FETCH_ASSOC);

            $pengaturan = new Pengaturan();
            $pengaturan->semua = $response;

            return $pengaturan;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function update(Pengaturan $pengaturan): Pengaturan
    {

        try {

            $statement = $this->connection->prepare("UPDATE pengaturan SET kg = ?, har = ? WHERE id = ?");
            $statement->execute([$pengaturan->kg, $pengaturan->har, $pengaturan->id]);

            return $pengaturan;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function mengambil_id(string $id): Pengaturan
    {

        try {

            $statement = $this->connection->prepare("SELECT * FROM pengaturan WHERE id = ?");
            $statement->execute([$id]);
            $response = $statement->fetchAll(PDO::FETCH_ASSOC);

            $pengaturan = new Pengaturan();
            $pengaturan->semua = $response;

            return $pengaturan;
        } catch (Exception $ex) {

            throw $ex;
        }
    }
}
