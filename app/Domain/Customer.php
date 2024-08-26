<?php

namespace Laundry\Domain;

class Customer
{
    public ?int $id = null;
    public ?array $semua = [];
    public string $name;
    public string $phone;
    public string $address;

}