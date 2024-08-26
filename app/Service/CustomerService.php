<?php

namespace laundry\Service;

use Exception;
use laundry\Domain\Customer;
use laundry\Config\Database;
use laundry\Exception\ValidationException;
use laundry\Model\Customer\CustomerFindAllRequest;
use laundry\Model\Customer\CustomerFindAllResponse;
use laundry\Repository\CustomerRepository;
use laundry\Model\Customer\CustomerSaveRequest;
use laundry\Model\Customer\CustomerSaveResponse;
use laundry\Model\Customer\CustomerEditRequest;
use laundry\Model\Customer\CustomerEditResponse;

class CustomerService{

    private CustomerRepository $CustomerRepository;

    public function __construct(CustomerRepository $CustomerRepoditory)
    {
        $this->CustomerRepository = $CustomerRepoditory;

    }

    public function save(CustomerSaveRequest $CustomerSaveRequest) : CustomerSaveResponse
    {

        $this->validateSave($CustomerSaveRequest);
        
        try{

            $request = new Customer();
            $request->name = $CustomerSaveRequest->name;
            $request->phone = $CustomerSaveRequest->phone;
            $request->address = $CustomerSaveRequest->address;

            $Customer = $this->CustomerRepository->save($request);

            $response = new CustomerSaveResponse();
            $response->customer = $Customer;
            return $response;
            

        }catch (\Exception $Exception) {

            throw $Exception;

        }
    }

    public function cek_data_save()
    {
        if(!isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['address'])){

            throw new ValidationException("name, phone, address tidak boleh kosong");
        }

    }

    private function validateSave(CustomerSaveRequest $customerSaveRequest)
    {
        if (
            $customerSaveRequest->name === null ||
            $customerSaveRequest->phone === null ||
            $customerSaveRequest->address === null ||
            trim($customerSaveRequest->name) === "" ||
            trim($customerSaveRequest->phone) === "" ||
            trim($customerSaveRequest->address) === ""
        ) {
            throw new ValidationException("Tidak ada yang boleh kosong");
        }
    }

    public function tampil(): CustomerFindAllResponse
    {

        
        $repository = $this->CustomerRepository->findAll();
        

        if($repository instanceof Customer){

            $response = new CustomerFindAllResponse();
        $response->customer = $repository;

        return $response;

        }
        

    }

    public function edit(CustomerEditRequest $customerEditRequest): CustomerEditResponse
    {

        $this->validateEdit($customerEditRequest);

        try{

            $request = new Customer();
            $request->id = $customerEditRequest->id;
            $request->name = $customerEditRequest->name;
            $request->phone = $customerEditRequest->phone;
            $request->address = $customerEditRequest->address;

            $customer = $this->CustomerRepository->update($request);

            $response = new CustomerEditResponse();
            $response->customer = $request;

            return $response;

        }catch(Exception $ex){

            throw $ex;
        }
    }

    public function cek_data_edit(array $data)
    {
        if(!isset($data['id']) || !isset($data['name']) || !isset($data['phone']) || !isset($data['address'])){

            throw new ValidationException("id, name, phone, address tidak boleh kosong");
        }

        $cek_id = $this->CustomerRepository->findById($data['id']);

        if($cek_id == null){

            throw new ValidationException("Id tidak ditemukan");


        }
    }
    
    private function validateEdit(CustomerEditRequest $customerSaveRequest)
    {
        if (
            $customerSaveRequest->id === null ||
            $customerSaveRequest->name === null ||
            $customerSaveRequest->phone === null ||
            $customerSaveRequest->address === null ||
            trim($customerSaveRequest->id) === "" ||
            trim($customerSaveRequest->name) === "" ||
            trim($customerSaveRequest->phone) === "" ||
            trim($customerSaveRequest->address) === ""
        ) {
            throw new ValidationException("Tidak ada yang boleh kosong");
        }
    }

    public function ambil(string $id): CustomerFindAllResponse
    {

        $response = $this->CustomerRepository->findById($id);

        $customer = new CustomerFindAllResponse();

        $customer->customer = $response;

        return $customer;
        
    }

    public function hapus(string $id):void
    {
        $this->validateHapus($id);

        $this->CustomerRepository->deleteById($id);
    }

    public function cek_data_hapus()
    {

        if(!isset($_GET['idc'])){

            throw new ValidationException("Id tidak boleh kosong");

        }

    }

    public function validateHapus(string $id)
    {
        
        $cek_id = $this->CustomerRepository->findById($id);

        if($cek_id == null){

            throw new ValidationException("Id tidak ditemukan");

        }
    }
    
    

}