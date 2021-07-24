<?php

require_once 'multi_image.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $item = $connection->getDataByIdWithImages($id)[$id];
    // $item = $connection->getDataById($id);
}else{
    $id = $_POST['id'];
    $item = $connection->getDataById($id);
}

$page_title = "Item Details";
include 'partials/header.php';

?>


    <div class="itempage">
        <div class="itempage-image">
            <h3>
                <?php echo isset($item['item_brand']) ? $item['item_brand']." " :"" ; echo isset($item['item_model']) ? $item['item_model'] :"" ; ?>
            </h3>
            <img id="itempage-image" src="<?php echo isset($item['item_image']) ? "res_images/".$item['item_image']."_res.".$item['image_ext']:"" ; ?>" alt="">
            <h3>
            <?php echo isset($item['item_price']) ? $item['item_price']." " :"PRICE NOT SET" ?>
            </h3>

<div class="multi-images">
    <?php foreach ($item['images'] as $image):?>
        <div>
        <img class="single-image" src="<?php echo isset($image['image_name']) ? "res_images/" . $image['image_name'] . "_res." . $image['image_ext'] : ""; ?>" alt="">                
        <form action="delete.php" method="POST" id="image_delete">
        <input type="hidden" name="image_id" value="<?php echo $image['image_id']; ?>">
        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
        <input type="submit" value="DELETE" id="delete_btn">
        </form>
        </div>
    <?php endforeach; ?>
    
</div>
        </div>
       
        <div class="itempage-body">
            <table class="itempage-details">
                <thead>
                    <tr>
                        <th>Header</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Brand</td>
                        <td><?php echo isset($item['item_brand']) ? $item['item_brand']:"" ; ?></td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td><?php echo isset($item['item_model']) ? $item['item_model']:"" ; ?></td>
                    </tr>

                    <tr>
                        <td>Size</td>
                        <td><?php echo isset($item['item_screen']) ? $item['item_screen']:"" ; ?></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><?php echo isset($item['item_description']) ? $item['item_description']:"" ; ?></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div> 


    <div class="form_container ">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="flex upload_form" enctype="multipart/form-data" method="POST">
        <h4>UPLOAD MORE ITEM IMAGES</h4>
        <div class="alert-<?php echo isset($msgClass) ? $msgClass : ""; ?>"><?php echo isset($errorMsg) ? $errorMsg : ""; ?></div>
        <input type="hidden" name="id" value="<?php echo isset($item['item_id']) ? $item['item_id'] : ""; ?>">
        <input type="hidden" name="multi_image" value="multi_image">
        <input type="hidden" name="item_type" value="<?php echo isset($item['item_type']) ? $item['item_type'] : ""; ?>">
        <input type="hidden" name="item_brand" value="<?php echo isset($item['item_brand']) ? $item['item_brand'] : ""; ?>">
 
        <div class="form_group ">
            <label for="item_image"> Picture 1:</label>
            <input type="file" name="item_image[]" id="" class="form_control">
            <small class="input_error">
                <?php
                echo isset($errors['item_image0']) ? "*" . $errors['item_image0'] : "";
                ?>
            </small>
        </div>
        <div class="form_group ">
            <label for="item_image"> Picture 2:</label>
            <input type="file" name="item_image[]" id="" class="form_control">
            <small class="input_error">
                <?php
                echo isset($errors['item_image1']) ? "*" . $errors['item_image1'] : "";
                ?>
            </small>
        </div>
        <div class="form_group ">
            <label for="item_image"> Picture 3:</label>
            <input type="file" name="item_image[]" id="" class="form_control">
            <small class="input_error">
                <?php
                echo isset($errors['item_image2']) ? "*" . $errors['item_image2'] : "";
                ?>
            </small>
        </div>
        <div class="form_group ">
            <label for="item_image"> Picture 4:</label>
            <input type="file" name="item_image[]" id="" class="form_control">
            <small class="input_error">
                <?php
                echo isset($errors['item_image3']) ? "*" . $errors['item_image3'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <input name="submit" type="submit" value="UPLOAD" id="upload_btn">
        </div>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
