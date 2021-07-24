<?php
$connection = require_once "connection.php";
$id = $_GET['id'];
$item = $connection->getDataById($id);
$item = $item;

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

<?php include 'partials/footer.php'; ?>
