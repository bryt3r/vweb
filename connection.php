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
        $statement->bindValue('price_set', 0);
        $statement->bindValue('costprice', 0);
        $statement->bindValue('sellingprice', 0);
        $statement->bindValue('discount', 0);
        $statement->bindValue('saleprice', 0);
        $statement->bindValue('listed', 0);
        $statement->bindValue('sold', 0);
        $statement->bindValue('date_created', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function getDataById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM items WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    
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
        $statement->bindValue('sold', 0);
        $statement->execute();
    }

    public function sold($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_sold = :sold WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('sold', 1);
        $statement->execute();
    }


    public function unlist($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_listed = :listed WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('listed', 0);
        $statement->execute();
    }

    public function list($id)
    {
        $statement = $this->pdo->prepare("UPDATE items SET item_listed = :listed WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->bindValue('listed', 1);
        $statement->execute();
    }

    public function removeData($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM items WHERE item_id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
    }

    public function insertImage($data)
    {
        $statement = $this->pdo->prepare("INSERT INTO images (image_name, image_ext, item_id, date_created) 
                                        VALUES(:image_name, :image_ext, :item_id, :date_created)");
        $statement->bindValue('image_name', $data['image_name']);
        $statement->bindValue('image_ext', $data['image_ext']);
        $statement->bindValue('item_id', $data['item_id']);
        $statement->bindValue('date_created', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function getDataByIdWithImages($id)
    {
        $start = 0;
        $limit = 5;
        $sql = "SELECT items.item_id as item_id, items.item_type as item_type, items.item_condition as item_condition,
                items.item_brand as item_brand, items.item_model as item_model, items.item_ram as item_ram,
                items.item_hdd as item_hdd, items.item_screen as item_screen, items.item_description as item_description,
                items.item_image as item_image, items.image_ext as image_ext, items.item_saleprice as item_saleprice,
                images.image_id as image_id, images.item_id as image_item_id, images.image_name as image_name, images.image_ext as images_ext 
        FROM items
        LEFT JOIN images ON items.item_id=images.item_id
        WHERE items.item_id=$id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
       

        $data = [];
        while ($row = $statement->fetch()) {
            $image = [
                'image_id' => $row['image_id'],
                'image_name' => $row['image_name'],
                'image_ext' => $row['images_ext'],
            ];
            if (!isset($data[$row['item_id']])) {
                $data[$row['item_id']] = [
                    'item_id' => $row['item_id'],
                    'item_type' => $row['item_type'],
                    'item_condition' => $row['item_condition'],
                    'item_brand' => $row['item_brand'],
                    'item_model' => $row['item_model'],
                    'item_ram' => $row['item_ram'],
                    'item_hdd' => $row['item_hdd'],
                    'item_screen' => $row['item_screen'],
                    'item_description' => $row['item_description'],
                    'item_image' => $row['item_image'],
                    'image_ext' => $row['image_ext'],
                    'item_saleprice' => $row['item_saleprice'],
                    'images' => [$image]
                ];
                $main_image = [
                    'image_name' => $row['item_image'],
                    'image_ext' => $row['images_ext'],
                ];
                array_unshift($data[$row['item_id']]['images'], $main_image);
            } else {
                $data[$row['item_id']]['images'][] = $image;
            }
        }
        
        // echo '<pre>';
        // var_dump($data);
        // echo '<pre>';
        return $data;
        
    }


    public function removeImage($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM images WHERE image_id = :id");
        $statement->bindValue('id', $id);
        $statement->execute();
    }
}

return new Connection();

//on any page just use $connection = require_once "connection.php";
//then use $connection as needed.
