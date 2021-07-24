<?php
require_once "updater.php";

$items = $connection->getAllData();

$page_title = "Admin Items";
include 'partials/header.php';
?>


<a href="item_upload.php">upload</a>
<a href="items.php">items</a>

<div class="alert-<?php echo isset($msgClass) ? $msgClass : ""; ?>"><?php echo isset($errorMsg) ? $errorMsg : ""; ?></div>
        
<div class="items">

    <?php foreach ($items as $item) : ?>
        
        <?php $soldOpen = ($item['item_sold']) ? '<div class="overlay"><h2> SOLD</h2>' : '' ; ?>
        <?php $soldClose = ($item['item_sold']) ? '</div>' : '' ; ?>

        <!-- SET PRICE MODAL -->
        <div id="price_modal">
            <div class="modal-header">
                <span class="close-btn">&times;</span>
                <h1>SET PRICE</h1>
            </div>
            <div class="modal-content">
                <p>this is the text inside the modal</p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="flex upload_form" method="POST">
                    <input type="hidden" name="id" value="<?php echo isset($item['item_id']) ? $item['item_id'] : ""; ?>">
                    <input type="hidden" name="price_setter" value="price_setter">
                    <div class="form_group ">
                        <label for="item_costprice">COST PRICE:</label>
                        <input type="number" name="item_costprice" id="" class="form_control" value="<?php echo isset($item['item_costprice']) ? $item['item_costprice'] : "" ?>">
                        <small class="input_error"><?php echo isset($errors['item_costprice']) ? "*" . $errors['item_costprice'] : ""; ?></small>
                    </div>
                    <div class="form_group ">
                        <label for="item_sellingprice">SELLING PRICE:</label>
                        <input type="number" name="item_sellingprice" id="" class="form_control" value="<?php echo isset($item['item_sellingprice']) ? $item['item_sellingprice'] : "" ?>">
                        <small class="input_error"><?php echo isset($errors['item_sellingprice']) ? "*" . $errors['item_sellingprice'] : ""; ?></small>
                    </div>
                    <div class="form_group ">
                        <label for="item_discount">DISCOUNT:</label>
                        <input disabled type="text" name="item_discount" id="" class="form_control" value="<?php echo isset($item['item_discount']) ? $item['item_discount']."%" : "" ?>">
                        <small class="input_error"><?php echo isset($errors['item_discount']) ? "*" . $errors['item_discount'] : ""; ?></small>
                    </div>
                    <div class="form_group ">
                        <label for="item_saleprice">SALE PRICE:</label>
                        <input type="number" name="item_saleprice" id="" class="form_control" value="<?php echo isset($item['item_saleprice']) ? $item['item_saleprice'] : "" ?>">
                        <small class="input_error"><?php echo isset($errors['item_saleprice']) ? "*" . $errors['item_saleprice'] : ""; ?></small>
                    </div>
                    <input type="submit" value="SET PRICE">
                </form>
            </div>
            <div class="modal-footer">
                <h2>I am the Footer</h2>
            </div>
        </div>
        <!-- SET PRICE MODAL ENDS -->

        <!-- <div onclick="location.href='item_page.php?id=<?php echo $item['item_id']; ?>';" style="cursor: pointer;"> -->
            <div onclick="location.href='admin_itempage.php?id=<?php echo $item['item_id']; ?>';" style="cursor: pointer;" class="item">
                <?php echo $soldOpen; ?>
                <div class="image-container <?php echo isset($item['item_sold']) && $item['item_sold'] ? 'sold-overlay' : 'unsold'; ?>">
                    <img class="item-image" src="<?php echo isset($item['item_image']) ? "res_images/" . $item['item_image'] . "_res." . $item['image_ext'] : ""; ?>" alt="">
                </div>
                <?php echo $soldClose; ?>
                <div class="item-body">
                    <ul class="item-details">
                        <li><?php echo isset($item['item_brand']) ? $item['item_brand'] . " " : "";
                            echo isset($item['item_model']) ? $item['item_model'] : ""; ?></li>
                        <li><?php echo isset($item['item_ram']) ? $item['item_ram'] . " RAM, " : "";
                            echo isset($item['item_hdd']) ? $item['item_hdd'] . " HDD" : ""; ?> </li>
                        <li><small><?php echo isset($item['item_condition']) ? ucfirst($item['item_condition']) : ""; ?></small></li>
                        <br>
                        <li class="<?php echo $val = ($item['price_set']) ? '' : 'input_error';?>"> <?php echo $val = ($item['price_set']) ? $item['item_saleprice'] : "<h5>PRICE NOT SET</h5>" ; ?> </li>
                        <li><button id="setprice">SET PRICE</button></li>
                    </ul>
                </div>
                <div class="item-admin">
                    <ul>
                        <li><a href="item_upload.php?id=<?php echo $item['item_id']; ?>"> <button id="edit_btn">EDIT ITEM</button></a></li>
                        <li>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="listed_form">
                                <input type="hidden" name="id" value="<?php echo $item['item_id']; ?>">
                                <input type="hidden" name="lister" value="<?php echo isset($item['item_listed']) && $item['item_listed'] ? 'listed' : 'unlisted'; ?>">
                                <input class="<?php echo isset($item['item_listed']) && $item['item_listed'] ? 'listed' : 'unlisted'; ?>" type="submit" value="<?php echo isset($item['item_listed']) && $item['item_listed'] ? 'LISTED' : 'UNLISTED'; ?>" id="listed_btn">
                            </form>
                        </li>
                        <li>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="sold_form">
                                <input type="hidden" name="id" value="<?php echo $item['item_id']; ?>">
                                <input type="hidden" name="sold" value="<?php echo isset($item['item_sold']) && $item['item_sold'] ? 'sold' : 'unsold'; ?>">
                                <input class="<?php echo isset($item['item_sold']) && $item['item_sold'] ? 'sold' : 'unsold'; ?>" type="submit" value="<?php echo isset($item['item_sold']) && $item['item_sold'] ? 'SOLD' : 'UNSOLD'; ?>" id="sold_btn">
                            </form>
                        </li>
                        <li>
                            <form action="delete.php" method="POST" id="delete_form">
                                <input type="hidden" name="id" value="<?php echo $item['item_id']; ?>">
                                <input type="submit" value="DELETE" id="delete_btn">
                            </form>

                        </li>
                    </ul>
                </div>
            </div>
        <!-- </div> -->
    <?php endforeach; ?>

</div>


<?php include 'partials/footer.php'; ?>