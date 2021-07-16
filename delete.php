<?php
$connection = require_once 'Connection.php';
$id = $_POST['id'] ?? "";
if ($id)
{
$connection->removeData($id);
header('Location: admin_items.php');
}