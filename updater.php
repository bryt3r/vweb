<?php

$connection = require_once "connection.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']?? "";
    $lister = $_POST['lister']?? "";
    $price_setter = $_POST['price_setter']?? "";
    $sold = $_POST['sold']?? "";

    if ($id && $lister) {
        if ($lister == 'listed') {
            $connection->unlist($id);
            header('Location: admin_items.php');
        } elseif ($lister == 'unlisted') {
            $connection->list($id);
            header('Location: admin_items.php');
        }
    } elseif($id && $sold){
        if ($sold == 'sold') {
            $connection->unsold($id);
            header('Location: admin_items.php');
        } elseif ($sold == 'unsold') {
            $connection->sold($id);
            header('Location: admin_items.php');
        }
    }elseif ($id && $price_setter) {
        $item_costprice = $_POST['item_costprice'];
        $item_sellingprice = $_POST['item_sellingprice'];
        // $item_discount = $_POST['item_discount'];
        $item_saleprice = $_POST['item_saleprice'];

        $data = [
            'item_costprice' => $item_costprice,  
            'item_sellingprice' => $item_sellingprice,
            'item_saleprice' => $item_saleprice   
        ];

        $errors = check_price($data);

        if (empty($errors)) {
            // update data to db;
            if (($data['item_sellingprice'] > 0) && ($data['item_saleprice'] > 0)) {
                $data['price_set'] = true;
            }
            if (($data['item_sellingprice'] <= 0) && ($data['item_saleprice'] <= 0)) {
                $data['price_set'] = false;
            } elseif (($data['item_sellingprice'] > 1) && ($data['item_saleprice'] <= 0)) {
                $data['item_saleprice'] = $data['item_sellingprice'];
                $data['price_set'] = true;
            }elseif (($data['item_sellingprice'] <= 0) && ($data['item_saleprice'] > 1)) {
                $data['item_sellingprice'] = $data['item_saleprice'];
                $data['price_set'] = true;
            }
            $data['item_discount'] = priceDiscount($data['item_sellingprice'], $data['item_saleprice']);
            if ($connection->updatePrice($id, $data)) {
                // $errorMsg = "Price Succesfully Updated";
                // $msgClass = "success";
                header('Location: admin_items.php');
                $errorMsg = "Price Succesfully Updated";
                $msgClass = "success";
            }else{
                $errorMsg = "Failed To Save";
                $msgClass = "warning";
                header('Location: admin_items.php');
            }
  
            
        } else {
            $errorMsg = "Update Failed Please Correct All Errors";
            $msgClass = "warning";
        }



    }
}


function priceDiscount($sellingPrice, $salePrice)
{
    if (ctype_digit($sellingPrice) && ctype_digit($salePrice)) {
        if ($sellingPrice > $salePrice){
            $item_discount = (($sellingPrice - $salePrice)/$sellingPrice)*100;
            return $item_discount;
        }elseif ($sellingPrice == $salePrice) {
            return 0;
        }elseif ($sellingPrice < $salePrice) {
            return 0; 
        }
        
    } else {
        return 0;
    }
    
}


function check_price($data)
{
    $errors = [];
    if (!empty($data['item_costprice'])) {
        if (!ctype_digit($data['item_costprice']) or ($data['item_costprice'] <0)) {
            $errors['item_costprice'] = "Please Enter Positive Digits Only";
        }
    }
    if (!empty($data['item_sellingprice'])) {
        if (!ctype_digit($data['item_sellingprice']) or ($data['item_sellingprice'] <0)) {
            $errors['item_sellingprice'] = "Please Enter Positive Digits Only";
        }
    }
    if (!empty($data['item_saleprice'])) {
        if (!ctype_digit($data['item_saleprice']) or ($data['item_saleprice'] <0)) {
            $errors['item_saleprice'] = "Please Enter Positive Digits Only";
        }
    }
    return $errors;
}

?>