<?php

namespace laundry\Controller;

use Exception;
use laundry\App\View;
use laundry\Repository\OrderRepository;
use laundry\Repository\OrderDetailsRepository;
use laundry\Service\OrderService;
use laundry\Service\OrderDetailsService;
use laundry\Model\Order\OrderSaveRequest;
use laundry\Model\Order\OrderSaveResponse;
use laundry\Model\OrderDetails\OrderDetailsSaveRequest;
use laundry\Model\OrderDetails\OrdeDetailsResponse;
use laundry\Repository\CustomerRepository;
use laundry\Service\CustomerService;
use laundry\Model\Customer\CustomerSaveRequest;
use laundry\Model\Customer\CustomerSaveResponse;
use laundry\Config\Database;
use laundry\Domain\Order;
use laundry\Exception\ValidationException;
use laundry\Repository\pengaturanrepository;
use laundry\Service\pengaturanservice;

class TransaksiController
{

    private OrderService $orderService;
    private OrderDetailsService $orderDetailsService;
    private CustomerService $customerService;
    private pengaturanservice $pengaturan;

    public function __construct()
    {

        $connection = Database::getConnection();
        $repository = new OrderRepository($connection);
        $details = new OrderDetailsRepository($connection);
        $orderService = new OrderService($repository, $details);
        $this->orderService = $orderService;

        $repository = new OrderDetailsRepository($connection);
        $orderDetailsService = new OrderDetailsService($repository);
        $this->orderDetailsService = $orderDetailsService;

        $repository = new CustomerRepository($connection);
        $customerService = new CustomerService($repository);
        $this->customerService = $customerService;

        $repository = new pengaturanrepository($connection);
        $this->pengaturan = new pengaturanservice($repository);
    }

    public function postTransaksi()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $pengaturan = $this->pengaturan->mengambil()->semua;
            $pengaturan = $pengaturan[0]['kg'];

            $this->orderService->cek_data_transaksi();

            $request = $this->orderService->transaksi($_POST['item_name'], $_POST['quantity'], $_POST['order_date'], $_POST['customer'], $pengaturan);

            http_response_code(200);
            echo json_encode(['message' => 'berhasil menambah transaksi']);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal menambah transaksi', 'error' => $ex->getMessage()]);
        }
    }

    public function pembayaran()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');

        try {

            $response = $this->orderService->semua();
            $data = $response->semua;

            http_response_code(200);
            echo json_encode(['message' => 'berhasil menampilkan pembayaran', 'data' => $data]);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal menampilkan pembayaran', 'error' => $ex->getMessage()]);
        }
    }

    public function ambilsesuai()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $this->orderService->cek_data_ambilsemua();

            $response = $this->orderService->ambilsesuai($_POST['start_date'], $_POST['end_date']);
            $data = $response->semua;

            http_response_code(200);
            echo json_encode(['message' => 'berhasil ambil data yang akan di cetak', 'data' => $data]);
        } catch (Exception $ex) {

            http_response_code(200);
            echo json_encode(['message' => 'gagal ambil data untuk di cetak', 'error' => $ex->getMessage()]);
        }
    }

    public function updatestatus()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $data = json_decode(file_get_contents('php://input'), true);
            $this->orderService->cek_data_updatestatus($data);

            $order = new Order();
            $order->id = $data['id'];
            $order->status = $data['status'];

            $this->orderService->updatestatus($order);

            $response = $this->orderService->semua();
            $data = $response->semua;

            http_response_code(200);
            echo json_encode(['message' => 'berhasil mengupdate status', 'data' => $data]);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal mengupdate status', 'error' => $ex->getMessage()]);
        }
    }

    public function ambil()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');

        try {

            $this->orderService->cek_data_ambil();

            $order = $this->orderService->ambil($_GET['ido'])->semua;

            http_response_code(200);
            echo json_encode(['message' => 'berhasil mengambil data', 'data' => [
                'id' => $order[0]['ido'],
                'total_amount' => $order[0]['total_amount'],
                'order_date' => $order[0]['order_date']
            ]]);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal mengambil data', 'error' => $ex->getMessage()]);
        }
    }
}
