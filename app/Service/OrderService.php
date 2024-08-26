<?php

namespace laundry\Service;

use DateTime;
use Exception;
use laundry\Domain\Order;
use laundry\Domain\OrderDetails;
use laundry\Config\Database;
use laundry\Exception\ValidationException;
use laundry\Model\Order\OrderSaveRequest;
use laundry\Model\Order\OrderSaveResponse;
use laundry\Model\OrderDetails\OrderDetailsSaveRequest;
use laundry\Model\OrderDetails\OrderDetailsResponse;
use laundry\Repository\OrderDetailsRepository;
use laundry\Repository\OrderRepository;

class OrderService
{


    private OrderRepository $orderRepository;
    private OrderDetailsRepository $orderDetailsRepository;

    public function __construct(OrderRepository $orderRepository, OrderDetailsRepository $orderDetailsRepository)
    {

        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->orderRepository = $orderRepository;
    }

    public function cekIdOrder(string $id): ?array
    {

        $ambil_data = $this->orderRepository->findById($id);
        return $ambil_data;
    }

    public function saveOrder(int $id_customer, string $order_date, int $total_amount)
    {

        $order = new Order();
        $order->customer_id = $id_customer;
        $order->order_date = $order_date;
        $order->total_amount = $total_amount;



        $response = $this->orderRepository->save($order);
        return $response;
    }

    public function saveOrderDetails(int $order_id, string $item_name, int $quantity, string $order_date)
    {

        $price = $this->hitungHargaOrderDetails($order_date, $item_name, $quantity);

        $order = new OrderDetails();
        $order->order_id = $order_id;
        $order->item_name = $item_name;
        $order->quantity = $quantity;
        $order->price = $price;



        $save = $this->orderDetailsRepository->save($order);
    }

    public function hitungHargaOrderDetails(string $ambil, string $jenis_kain, string $quantity, ?int $pengaturan = null)
    {

        $quantity = (int) $quantity;

        $harga_bayar = $quantity * $pengaturan;

        return $harga_bayar;
    }

    public function transaksi(string $item_name, string $quantity,  string $order_date, string $id_customer, int $pengaturan)
    {

        $this->validateTransaksi($item_name,  $quantity, $order_date, $id_customer);

        try {

            $harga = $this->hitungHargaOrderDetails($order_date, $item_name, $quantity, $pengaturan);
            $simpan_order = $this->saveOrder($id_customer, $order_date, $harga);
            $simpan_detail = $this->saveOrderDetails($simpan_order, $item_name, $quantity, $order_date);
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function cek_data_transaksi()
    {
        if (!isset($_POST['item_name']) || !isset($_POST['quantity']) || !isset($_POST['order_date']) || !isset($_POST['customer'])) {

            throw new ValidationException("item name, quantity, customer dan order date  tidak boleh kosong");
        }

    }

    private function validateTransaksi(string $item_name, string $quantity,  string $order_date, string $id_customer)
    {
        if (
            $item_name === null ||
            $quantity === null ||
            $order_date === null ||
            $id_customer === null ||
            trim($item_name) === "" ||
            trim($quantity) === "" ||
            trim($order_date) === "" ||
            trim($id_customer) === ""
        ) {
            throw new ValidationException("Tidak ada yang boleh string kosong");
        }

        $cek_id_customer = $this->orderRepository->ambil_id_customer($id_customer);

        if($cek_id_customer == null){

            throw new ValidationException("Id Customer Tidak ditemukan");
        }

        
    }

    public function semua()
    {

        return $this->orderRepository->FindAll();
    }

    public function ambilsesuai(string $star_date, string $end_date)
    {

        $this->validateAmbilSemua($star_date, $end_date);

        try{

            return $this->orderRepository->ambilsesuai($star_date, $end_date);


        }catch(Exception $ex){

            throw $ex;

        }
        
    }

    public function cek_data_ambilsemua()
    {
        if (!isset($_POST['start_date']) || !isset($_POST['end_date'])) {

            throw new ValidationException("start_date dan end date tidak boleh kosong");
        }

    }

    private function validateAmbilSemua(string $star_date, string $end_date)
    {
        if (
            $star_date === null ||
            $end_date === null ||
            trim($star_date) === "" ||
            trim($end_date) === ""
        ) {
            throw new ValidationException("Tidak ada yang boleh string kosong");
        }

        
    }

    public function semuas($idc, $ido, $idd)
    {

        return $this->orderRepository->semua($idc, $ido, $idd);
    }

    public function updatestatus(Order $order)
    {

        $this->validateUpdateStatus($order);

        try{

            $this->orderRepository->updatestatus($order);


        }catch(Exception $ex){

            throw $ex;

        }
        
    }

    public function cek_data_updatestatus( array $data)
    {
        if(!isset($data['id']) || !isset($data['status'])) {

            throw new ValidationException("id dan status tidak boleh kosong");
        }

    }

    private function validateUpdateStatus(Order $order)
    {
        if (
            $order->id === null ||
            $order->status === null ||
            trim($order->id) === "" ||
            trim($order->status) === ""
        ) {
            throw new ValidationException("Tidak ada yang boleh string kosong");
        }

        $cek_id = $this->ambil($order->id);
        $cek_id = $cek_id->semua;

        if(!isset($cek_id[0]['ido'])){

            throw new ValidationException("Id tidak ditemukan");
        }

        if($order->status !== "pending" AND $order->status !== "completed"){

            throw new ValidationException("status cuman boleh disi pending atau completed");
        }

        
    }

    public function ambil(string $ido): Order
    {
        $this->validateAmbil($ido);

        try{

            return $this->orderRepository->ambil($ido);


        }catch(Exception $ex){

            throw $ex;

        }
        
    }

    public function cek_data_ambil()
    {
        if(!isset($_GET['ido'])) {

            throw new ValidationException("ido tidak boleh kosong");
        }

    }

    private function validateAmbil(string $id)
    {
        if (
            $id === null ||
            trim($id) === ""
        ) {
            throw new ValidationException("Tidak ada yang boleh string kosong");
        }

        $cek_id = $this->orderRepository->ambil($id);
        $cek_id = $cek_id->semua;

        if(!isset($cek_id[0]['ido'])){

            throw new ValidationException("Id tidak ditemukan");
        }

        
    }
}
