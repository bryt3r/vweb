<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:server=localhost;dbname=shopdb', 'admin', 'abc123');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllData()
    {
        $statement = $this->pdo->prepare("SELECT * FROM items ORDER BY date_created DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertData($data)
    {
        $statement = $this->pdo->prepare("INSERT INTO items (item_type, item_condition, item_brand, item_model, item_ram, item_hdd, item_screen, item_description,
         item_image, image_ext, price_set,item_costprice, item_sellingprice, item_discount, item_saleprice, item_listed, item_sold, date_created) 
                                        VALUES(:type, :condition, :brand, :model, :ram, :hdd, :screen, :description, :image, :image_ext,
                                         :price_set,:costprice, :sellingprice, :discount, :saleprice, :listed, :sold, :date_created)");
        $statement->bindValue('type', $data['item_type']);
        $statement->bindValue('condition', $data['item_condition']);
        $statement->bindValue('brand', $data['item_brand']);
        $statement->bindValue('model', $data['item_model']);
        $statement->bindValue('ram', $data['item_ram']);
        $statement->bindValue('hdd', $data['item_hdd']);
        $statement->bindValue('screen', $data['item_screen']);
        $statement->bindValue('description', $data['item_description']);
        $statement->bindValue('image', $data['item_image']);
        $statement->bindValue('image_ext', $data['image_ext']);
        $statement->bindValue('price_set', false);
        $statement->bindValue('costprice', 0);
        $statement->bindValue('sellingprice', 0);
        $statement->bindValue('discount', 0);
        $statement->bindValue('saleprice', 0);
        $statement->bindValue('listed', false);
        $statement->bindValue('sold', false);
        $statement->bindValue('date_created', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function getDataById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM items WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function updateData($id, $data)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_type = :type, item_condition = :condition, item_brand =:brand,
         item_model = :model, item_ram = :ram, item_hdd = :hdd, item_screen = :screen, item_description = :description, date_updated = :date_updated WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('type', $data['item_type']);
        $statement->bindValue('condition', $data['item_condition']);
        $statement->bindValue('brand', $data['item_brand']);
        $statement->bindValue('model', $data['item_model']);
        $statement->bindValue('ram', $data['item_ram']);
        $statement->bindValue('hdd', $data['item_hdd']);
        $statement->bindValue('screen', $data['item_screen']);
        $statement->bindValue('description', $data['item_description']);
        $statement->bindValue('date_updated', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function updatePrice($id, $data)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_costprice = :costprice, item_sellingprice = :sellingprice, item_discount =:discount,
        item_saleprice = :saleprice, price_set = :price_set WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('costprice', $data['item_costprice']);
        $statement->bindValue('sellingprice', $data['item_sellingprice']);
        $statement->bindValue('discount', $data['item_discount']);
        $statement->bindValue('saleprice', $data['item_saleprice']);
        $statement->bindValue('price_set', $data['price_set']);
        $statement->execute();
    }

    public function unsold($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_sold = :sold WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('sold', false);
        $statement->execute();
    }

    public function sold($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_sold = :sold WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('sold', true);
        $statement->execute();
    }


    public function unlist($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_listed = :listed WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('listed', false);
        $statement->execute();
    }

    public function list($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_listed = :listed WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('listed', true);
        $statement->execute();
    }

    public function removeData($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM items WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
    }
}

return new Connection();

//on any page just use $connection = require_once "connection.php";
//then use $connection as needed.
