<?php 

require_once("ak_php_img_lib_1.0.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['id'];
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

            echo '<pre>';
            var_dump($item_id);
            var_dump($filename);
            var_dump($fileExt);
            echo'</pre>';
        }  
        
    }

}






?>