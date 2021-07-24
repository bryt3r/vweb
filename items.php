<?php
$connection = require_once "connection.php";
$items = $connection->getAllData();

$page_title = "Items";
include 'partials/header.php';
?>



        
        <a href="item_upload.php">upload</a>
        <a href="items.php">items</a>
        <div class="items">
            
            <?php foreach ($items as $item): ?>
                <div onclick="location.href='item_page.php?id=<?php echo $item['item_id']; ?>';" style="cursor: pointer;">     
                    <div class="item">
                        <div class="image-container">
                            <img class="item-image" src="<?php echo isset($item['item_image']) ? "res_images/".$item['item_image']."_res.".$item['image_ext']:"" ; ?>" alt="">
                        </div>
                        <div class="item-body">
                            <ul class="item-details">
                                <li><?php echo isset($item['item_brand']) ? $item['item_brand']." ":"" ; echo isset($item['item_model']) ? $item['item_model']:"" ; ?></li>
                                <li><?php echo isset($item['item_ram']) ? $item['item_ram']." RAM, ":"" ; echo isset($item['item_hdd']) ? $item['item_hdd']." HDD":"" ; ?> </li>
                                <li><small><?php echo isset($item['item_condition']) ? ucfirst($item['item_condition']) : ""; ?></small></li>
                                <br>
                                <?php if ($item['item_discount']): ?>
                                <li> <?php echo isset($item['item_sellingprice']) ? $item['item_sellingprice'] : "" ; ?>  | <?php echo isset($item['item_discount']) ? $item['item_discount']."%" : "" ; ?> </li>
                                <?php endif; ?>
                                <li> <?php echo isset($item['item_saleprice']) ? $item['item_saleprice'] : "" ; ?> </li>
                                
                            
                            </ul>
                        </div>

                    </div>
                </div>    
            <?php endforeach; ?> 

        </div>
    

<?php include 'partials/footer.php'; ?>

