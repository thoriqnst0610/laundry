<?php

namespace Laundry\Domain;

class OrderDetails{

    public int $id;
    public int $order_id;
    public string $item_name;
    public int $quantity;
    public int $price;
    
}