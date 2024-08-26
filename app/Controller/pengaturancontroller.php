<?php

namespace laundry\Controller;

use Exception;
use laundry\App\View;
use laundry\Config\Database;
use laundry\Domain\Pengaturan;
use laundry\Repository\pengaturanrepository;
use laundry\Service\pengaturanservice;

class pengaturancontroller
{

    private pengaturanservice $service;

    public function __construct()
    {
        $database = Database::getConnection();
        $repository = new pengaturanrepository($database);
        $this->service = new pengaturanservice($repository);
    }


    public function mengedit()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $data = json_decode(file_get_contents('php://input'), true);

            $pengaturan = new Pengaturan();
            $pengaturan->id = $data['id'];
            $pengaturan->kg = $data['kg'];
            $pengaturan->har = $data['hr'];

            $this->service->mengedit($pengaturan);

            http_response_code(200);
            echo json_encode(['message' => 'berhasil mengupdate pengaturan']);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal mengupdate pengaturan', 'error' => $ex->getMessage()]);
        }
    }
}
