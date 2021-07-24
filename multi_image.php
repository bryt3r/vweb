<?php 

require_once("ak_php_img_lib_1.0.php");
require_once("create.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['id'];
    $item_type = $_POST['item_type'];
    $item_brand = $_POST['item_brand'];
    $errors = [];
    echo '<pre>';
    var_dump($_FILES);
    echo'</pre>';
    $files_tmp = $_FILES['item_image']['tmp_name'];
    foreach ($files_tmp as $key => $value) {
        $files = $_FILES['item_image'];
        if ($files['error'][$key] == 4) {
            $errors['item_image'.$key] = "this field is required";
            $errorMsg = "Upload Failed Please Correct All Errors";
            $msgClass = "warning";
        } else {
            
            $filename = stripslashes($files['name'][$key]);
            $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
            $fileExt = strtolower($fileExt);
            if ($files['size'][$key] > 2 * 1024 * 1024) {
                $errors['item_image'.$key] = "You can not upload more than 2MB image";
                unlink($files['tmp_name'][0]);
                $errorMsg = "Upload Failed Please Correct All Errors";
                $msgClass = "warning";
            } elseif (!in_array($fileExt, ['jpg'])) {
                $errors['item_image'.$key] = "Please upload only .jpg images";
                $errorMsg = "Upload Failed Please Correct All Errors";
                $msgClass = "warning";
                if ($files['tmp_name'][$key]) {
                    unlink($files['tmp_name'][$key]);
                }
            }
            if (empty($errors)) {
                // save data to db;
                // uploadImage($item_type)
                // resizeimage($fileName, $fileExt)
                $uploaded_file = __DIR__ . "/images/" . $item_type . "_" . $item_brand . "_" . time() . "_" .$key. "." . $fileExt;
                if (!move_uploaded_file($files['tmp_name'][$key], $uploaded_file)) {
                    return false;
                } else {
                    $uploaded_filename = pathinfo($uploaded_file, PATHINFO_FILENAME);
                
                    $data = [
                        'image_name' => $uploaded_filename,
                        'image_ext' => $fileExt,
                        'item_id' => $item_id,
                    ];
                    resizeimage($uploaded_filename, $fileExt);
                    // echo '<pre>';
                    // var_dump($item_id);
                    // var_dump($filename);
                    // var_dump($fileExt);
                    // echo'</pre>';
                    $connection->insertImage($data);
                    header("Location: admin_itempage.php?id=$item_id");
                }
            } else {
                $errorMsg = "Upload Failed Please Correct All Errors";
                $msgClass = "warning";
            }
            
        }  
        
    }

}






?>