<?php

namespace laundry\Controller;

use Exception;
use laundry\App\View;
use laundry\Repository\CustomerRepository;
use laundry\Service\CustomerService;
use laundry\Model\Customer\CustomerSaveRequest;
use laundry\Model\Customer\CustomerSaveResponse;
use laundry\Config\Database;
use Laundry\Domain\Customer;
use laundry\Exception\ValidationException;
use laundry\Model\Customer\CustomerEditRequest;

class CustomerController
{

    private CustomerService $customerService;

    public function __construct()
    {

        $connection = Database::getConnection();
        $repository = new CustomerRepository($connection);
        $customerService = new CustomerService($repository);
        $this->customerService = $customerService;
    }

    public function postSave()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $this->customerService->cek_data_save();

            $request = new CustomerSaveRequest();
            $request->name = $_POST['name'];
            $request->phone = $_POST['phone'];
            $request->address = $_POST['address'];

            $response = $this->customerService->save($request);

            http_response_code(200);
            echo json_encode(['message' => 'berhasil menambah data']);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal menambah data', 'error' => $ex->getMessage()]);
        }
    }

    public function tampil()
    {


        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');

        try {

            $response = $this->customerService->tampil();
            $data = $response->customer;
            $data = $data->semua;

            http_response_code(200);
            echo json_encode(['message' => 'berhasil menampilkan data', 'data' => $data]);
        } catch (ValidationException $ex) {

            http_response_code(200);
            echo json_encode(['message' => 'data kosong']);
        }
    }

    public function postEdit()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $data = json_decode(file_get_contents('php://input'), true);

            $this->customerService->cek_data_edit($data);

            $request = new CustomerEditRequest();
            $request->id = $data['id'];
            $request->name = $data['name'];
            $request->phone = $data['phone'];
            $request->address = $data['address'];

            $response = $this->customerService->edit($request);

            http_response_code(200);
            echo json_encode(['message' => 'berhasil mengedit data']);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal mengedit data', 'error' => $ex->getMessage()]);
        }
    }

    public function hapus()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');

        try {

            $this->customerService->cek_data_hapus();

            $this->customerService->hapus($_GET['idc']);

            http_response_code(200);
            echo json_encode(['message' => 'berhasil menghapus data']);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal menghapus data', 'error' => $ex->getMessage()]);
        }
    }
}
