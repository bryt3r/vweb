<?php
$connection = require_once 'Connection.php';
$id = $_POST['id'] ?? "";
$image_id = $_POST['image_id'];
$item_id = $_POST['item_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($id) {
        $connection->removeData($id);
        header('Location: admin_items.php');
    } elseif ($image_id) {
        $connection->removeImage($image_id);
        header("Location: admin_itempage.php?id=$item_id");
    }
}
