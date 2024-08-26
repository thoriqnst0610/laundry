<?php

namespace laundry\Service;

use Exception;
use laundry\Domain\Pengaturan;
use laundry\Exception\ValidationException;
use laundry\Repository\pengaturanrepository;

class pengaturanservice{

    private pengaturanrepository $repository;

    public function __construct(pengaturanrepository $repository)
    {
        
        $this->repository = $repository;
    }

    public function mengambil():Pengaturan
    {
        return $this->repository->mengambil();
    }

    public function mengedit(Pengaturan $pengaturan):void
    {

        $this->validateMengedit($pengaturan);

        try{

            $this->repository->update($pengaturan);


        }catch(Exception $ex){

            throw $ex;
            
        }

        
        
    }

    private function validateMengedit(Pengaturan $pengaturan)
    {
        if (
            $pengaturan->id == null || $pengaturan->kg == null || $pengaturan->har == null ||
            trim($pengaturan->id) == "" || trim($pengaturan->kg) == "" || $pengaturan->har == ""
        ) {
            throw new ValidationException("id, kg, har tidak boleh kosong");
        }

        $cek_id = $this->repository->mengambil_id($pengaturan->id);
        $cek_id = $cek_id->semua;
        
        if(!isset($cek_id[0]['id'])){

            throw new ValidationException("maaf id tidak ditemuka");
        }
    }
}