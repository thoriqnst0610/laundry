<?php

namespace laundry\Repository;

use Exception;
use laundry\Domain\Order;
use PDO;

class OrderRepository
{

    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Order $customer): int
    {

        try {

            $statement = $this->connection->prepare("insert into orders(customer_id,order_date,total_amount) values(?,?,?)");
            $statement->execute([$customer->customer_id, $customer->order_date, $customer->total_amount]);
            //return $customer->id;
            $lastInsertId = $this->connection->lastInsertId();

            return $lastInsertId;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function update(Order $user): Order
    {
        try {

            $statement = $this->connection->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
            $statement->execute([
                $user->total_amount,
                $user->id
            ]);
            return $user;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function findById(string $id): ?array
    {

        $id = (int) $id;
        try {
            
            $statement = $this->connection->prepare("SELECT * FROM order WHERE ido = ?");
            
           
            $statement->execute([$id]);
    
            
            return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $ex) {
            
            throw $ex;
        } finally {
            
            $statement->closeCursor();
        }
    }
    

    public function FindAll(): array|Order
    {


        try {

            $statement = $this->connection->prepare("SELECT *
    FROM customers
    JOIN orders ON customers.idc = orders.customer_id
    JOIN order_details ON orders.ido = order_details.order_id;

");

            $statement->execute([]);

            if ($row = $statement->fetchAll(PDO::FETCH_ASSOC)) {

                $response = new Order();
                $response->semua = $row;

                return $response;
            } else {

                $row = $statement->fetchAll(PDO::FETCH_ASSOC);

                $response = new Order();
                $response->semua = $row;

                return $response;
            }
        } catch (Exception $ex) {

            throw $ex;
        } finally {

            $statement->closeCursor();
        }
    }

    public function semua($idc, $ido, $idd): array|Order
    {


        try {

            $statement = $this->connection->prepare("SELECT *
        FROM customers
        JOIN orders ON customers.idc = orders.customer_id
        JOIN order_details ON orders.ido = order_details.order_id
        WHERE customers.idc = :idc AND orders.ido = :ido AND order_details.idd = :idd");

            // Gantikan nilai :idc, :ido, dan :idd dengan nilai yang sesuai


            $statement->bindParam(':idc', $idc);
            $statement->bindParam(':ido', $ido);
            $statement->bindParam(':idd', $idd);

            $statement->execute();

            if ($row = $statement->fetchAll(PDO::FETCH_ASSOC)) {

                $response = new Order();
                $response->semua = $row;

                return $response;
            } else {

                $row = $statement->fetchAll(PDO::FETCH_ASSOC);

                $response = new Order();
                $response->semua = $row;

                return $response;
            }
        } catch (Exception $ex) {

            throw $ex;
        } finally {

            $statement->closeCursor();
        }
    }

    public function ambilsesuai(string $start_date, string $end_date): array|Order
    {


        try {

            $statement = $this->connection->prepare("
        SELECT *
        FROM customers
        JOIN orders ON customers.idc = orders.customer_id
        JOIN order_details ON orders.ido = order_details.order_id
        WHERE orders.order_date BETWEEN ? AND ?
    ");
            $statement->execute([$start_date, $end_date]);

            if ($row = $statement->fetchAll(PDO::FETCH_ASSOC)) {

                $response = new Order();
                $response->semua = $row;

                return $response;
            } else {

                $row = $statement->fetchAll(PDO::FETCH_ASSOC);

                $response = new Order();
                $response->semua = $row;

                return $response;
            }
        } catch (Exception $ex) {

            throw $ex;
        } finally {

            $statement->closeCursor();
        }
    }

    public function updatestatus(Order $user): Order
    {

        try {

            $statement = $this->connection->prepare("UPDATE orders SET status = ? WHERE ido = ?");
            $statement->execute([
                $user->status,
                $user->id
            ]);
            return $user;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function ambil(string $ido): Order
    {
        try {

            $statement = $this->connection->prepare("SELECT * FROM orders WHERE ido = ?");
            $statement->execute([$ido]);

            $order = new Order();
            $order->semua =  $statement->fetchAll(PDO::FETCH_ASSOC);
            return $order;
        } catch (Exception $ex) {

            throw $ex;
        }
    }

    public function ambil_id_customer(string $id): array | null
    {
        try {

            $statement = $this->connection->prepare("SELECT * FROM customers WHERE idc = ?");


            $statement->execute([$id]);


            $row = $statement->fetch(PDO::FETCH_ASSOC);


            if ($row) {

                return [
                    'idc' => $row['idc'],
                    'name' => $row['name'],
                    'phone' => $row['phone'],
                    'address' => $row['address']
                ];
            } else {

                return null;
            }
        } catch (Exception $ex) {

            throw $ex;
        } finally {

            $statement->closeCursor();
        }
    }
}
