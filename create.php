<?php

require_once("ak_php_img_lib_1.0.php");
$connection = require_once "connection.php";
date_default_timezone_set('Africa/Lagos');

$errors = [];

$item_types = ['computer', 'phone', 'others'];
$item_conditions = ['new', 'pre-owned'];
$ram_sizes = ['1GB', '2GB', '3GB', '4GB', '5GB', '6GB', '8GB', '9GB', '10GB', '12GB', '16GB'];
$hdd_sizes = ['64GB', '120GB', '250GB', '256GB', '320GB', '500GB', '1TB'];
$screen_sizes = ['10 inches', '11 inches', '12 inches', '13 inches', '14 inches', '15 inches', '17 inches'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$_POST['multi_image']) {

    $item_type = checkPost('item_type');
    $item_condition = checkPost('item_condition');
    $item_brand = checkPost('item_brand');
    $item_model = checkPost('item_model');
    $item_ram = checkPost('item_ram');
    $item_hdd = checkPost('item_hdd');
    $item_screen = checkPost('item_screen');
    $item_description = checkPost('item_description');

    $data = [
        'item_type' => $item_type,
        'item_condition' => $item_condition,
        'item_brand' => $item_brand,
        'item_model' => $item_model,
        'item_ram' => $item_ram,
        'item_hdd' => $item_hdd,
        'item_screen' => $item_screen,
        'item_description' => $item_description,
    ];

    if ($_POST['id']) {
        $id = $_POST['id'];

        $errors = check_required($data);

        // foreach ($errors as $key => $error) {
        //     echo $key . " => " . $error;
        //     echo "</br>";
        // }

        if (empty($errors)) {
            // update data to db;
            $connection->updateData($id, $data);
            header('Location: admin_items.php');
            
        } else {
            $errorMsg = "Upload Failed Please Correct All Errors";
            $msgClass = "warning";
        }
        
    } else {
        // // print_r($_POST);
        // $unixTime = time('Y-m-d H:i:s');
        // print_r(getdate($unixTime));
        // exit();


        $errors = check_required($data);

        if ($_FILES['item_image']['error'] == 4) {
            $errors['item_image'] = "this field is required";
        } else {
            $file = $_FILES['item_image'];
            $filename = stripslashes($file['name']);
            $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
            $fileExt = strtolower($fileExt);
            if ($file['size'] > 2 * 1024 * 1024) {
                $errors['item_image'] = "You can not upload more than 2MB image";
                unlink($file['tmp_name']);
            } elseif (!in_array($fileExt, ['jpg'])) {
                $errors['item_image'] = "Please upload only .jpg images";
                if ($file['tmp_name']) {
                    unlink($file['tmp_name']);
                }
            }
        }
        // foreach ($errors as $key => $error) {
        //     echo $key . " => " . $error;
        //     echo "</br>";
        // }

        if (empty($errors)) {
            // save data to db;
            // uploadImage($item_type)
            // resizeimage($fileName, $fileExt)
            $uploaded = uploadImage($item_type, $item_brand);
            if ($uploaded) {
                $data['item_image'] = $uploaded[0];
                $data['image_ext'] = $uploaded[1];
                resizeimage($uploaded[0], $uploaded[1]);
                $connection->insertData($data);
                header('Location: admin_items.php');
            }
        } else {
            $errorMsg = "Upload Failed Please Correct All Errors";
            $msgClass = "warning";
        }
    }
} 

function checkPost($field_name)
{
    $post_data = $_POST[$field_name];
    $data = stripslashes(trim($post_data));
    $data = htmlspecialchars($data);
    return $data;
}

function check_required($data)
{
    $errors = [];
    if (empty($data['item_type'])) {
        $errors['item_type'] = "this field is required";
    }
    if (empty($data['item_condition'])) {
        $errors['item_condition'] = "this field is required";
    }
    if (empty($data['item_brand'])) {
        $errors['item_brand'] = "this field is required";
    }
    if (empty($data['item_model'])) {
        $errors['item_model'] = "this field is required";
    }
    if (empty($data['item_ram'])) {
        $errors['item_ram'] = "this field is required";
    }
    if (empty($data['item_hdd'])) {
        $errors['item_hdd'] = "this field is required";
    }
    if (empty($data['item_screen'])) {
        $errors['item_screen'] = "this field is required";
    }
    if (empty($data['item_description'])) {
        $errors['item_description'] = "this field is required";
    }
    return $errors;
}

function uploadImage($item_type, $item_brand)
{
    if (!is_dir(__DIR__ . "/images")) {
        mkdir(__DIR__ . "/images");
    }
    $file = $_FILES['item_image'];
    $filename = $file['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $ext = strtolower($ext);
    $uploaded_file = __DIR__ . "/images/" . $item_type . "_" . $item_brand . "_" . time() . "." . $ext;
    if (!move_uploaded_file($file['tmp_name'], $uploaded_file)) {
        return false;
    } else {
        $uploaded_filename = pathinfo($uploaded_file, PATHINFO_FILENAME);
        $fileDetails = [$uploaded_filename, $ext];
        // print_r($fileDetails);
        return $fileDetails;
    }

}

function resizeimage($filename, $fileExt)
{
    if (!is_dir(__DIR__ . "/res_images")) {
        mkdir(__DIR__ . "/res_images");
    }
    $target_file = __DIR__ . "/images/$filename.$fileExt";
    $resized_file =  __DIR__ . "/res_images/" . $filename . "_res." . $fileExt;
    $wmax = 140;
    $hmax = 105;
    ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
}
