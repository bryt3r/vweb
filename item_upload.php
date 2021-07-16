<?php

require_once 'create.php';

$page_title = "Upload Item";
include 'partials/header.php';
$formData = [];
$id = isset($_GET['item_id']) ? $_GET['item_id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $id) {
    $itemData = $connection->getDataById($id)[0];
    $formData = $itemData;
    // print_r($formData);
    // exit;
}else{
    $formData = $_POST;
}

?>

<a href="admin_items.php">ADMIN items</a>
<a href="item_upload.php">upload</a>
<a href="items.php">items</a>

<div class="form_container ">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="flex upload_form" enctype="multipart/form-data" method="POST">
        <h4><?php echo isset($formData['item_id']) ? "EDIT ITEM" : "UPLOAD ITEM"; ?></h4>
        <div class="alert-<?php echo isset($msgClass) ? $msgClass : ""; ?>"><?php echo isset($errorMsg) ? $errorMsg : ""; ?></div>
        <input type="hidden" name="id" value="<?php echo isset($formData['item_id']) ? $formData['item_id'] : ""; ?>">
        <div class="form_group">
            <label class="xy" for="item_type">Select Item Type:</label>
            <select name="item_type" id="" class="form_control item_type">
                <option value="">Select Item Type</option>
                <?php foreach ($item_types as $type) : ?>
                    <option value="<?php echo $type; ?>" <?php echo (isset($formData['item_type']) && ($formData['item_type'] == $type)) ? "selected" : ""  ?>><?php echo ucfirst($type); ?></option>
                <?php endforeach ?>
            </select>
            <small class="input_error">
                <?php
                echo isset($errors['item_type']) ? "*" . $errors['item_type'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <label class="xy" for="item_type">Item Condition:</label>
            <select name="item_condition" id="" class="form_control">
                <option value="">Select Condition</option>
                <?php foreach ($item_conditions as $condition) : ?>
                    <option value="<?php echo $condition; ?>" <?php echo (isset($formData['item_condition']) && ($formData['item_condition'] == $condition)) ? "selected" : ""  ?>><?php echo ucfirst($condition); ?></option>
                <?php endforeach ?>
            </select>
            <small class="input_error">
                <?php
                echo isset($errors['item_condition']) ? "*" . $errors['item_condition'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <label for="item_brand">Item Brand:</label>
            <input type="text" name="item_brand" id="" class="form_control" value="<?php echo isset($formData['item_brand']) ? $formData['item_brand'] : "" ?>">
            <small class="input_error">
                <?php
                echo isset($errors['item_brand']) ? "*" . $errors['item_brand'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <label for="item_model">Model:</label>
            <input type="text" name="item_model" id="" class="form_control" value="<?php echo isset($formData['item_model']) ? $formData['item_model'] : "" ?>">
            <small class="input_error">
                <?php
                echo isset($errors['item_model']) ? "*" . $errors['item_model'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle" id="pc_fields">
            <label for="item_ram">RAM Size:</label>
            <select name="item_ram" id="" class="form_control">
                <option value="">Select RAM Size</option>
                <?php foreach ($ram_sizes as $size) : ?>
                    <option value="<?php echo $size; ?>" <?php echo (isset($formData['item_ram']) && ($formData['item_ram'] == $size)) ? "selected" : ""  ?>><?php echo $size; ?></option>
                <?php endforeach ?>

            </select>
            <small class="input_error">
                <?php
                echo isset($errors['item_ram']) ? "*" . $errors['item_ram'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle" id="pc_fields">
            <label for="item_hdd">HDD Size:</label>
            <select name="item_hdd" id="" class="form_control">
                <option value="">Select HDD Size</option>
                <?php foreach ($hdd_sizes as $size) : ?>
                    <option value="<?php echo $size; ?>" <?php echo (isset($formData['item_hdd']) && ($formData['item_hdd'] == $size)) ? "selected" : ""  ?>><?php echo $size; ?></option>
                <?php endforeach ?>
            </select>
            <small class="input_error">
                <?php
                echo isset($errors['item_hdd']) ? "*" . $errors['item_hdd'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle" id="pc_fields">
            <label for="item_screen">Screen Size:</label>
            <select name="item_screen" id="" class="form_control">
                <option value="">Select Screen Size</option>
                <?php foreach ($screen_sizes as $size) : ?>
                    <option value="<?php echo $size; ?>" <?php echo (isset($formData['item_screen']) && ($formData['item_screen'] == $size)) ? "selected" : ""  ?>><?php echo $size; ?></option>
                <?php endforeach ?>
            </select>
            <small class="input_error">
                <?php
                echo isset($errors['item_screen']) ? "*" . $errors['item_screen'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <label for="item_description">Description:</label>
            <textarea name="item_description" id="" cols="30" rows="5" class="form_control">
                <?php echo isset($formData['item_description']) ? $formData['item_description'] : "" ?>
                </textarea>
            <small class="input_error">
                <?php
                echo isset($errors['item_description']) ? "*" . $errors['item_description'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <label for="item_image">Upload Pictures:</label>
            <input type="file" name="item_image" id="" class="form_control">
            <small class="input_error">
                <?php
                echo isset($errors['item_image']) ? "*" . $errors['item_image'] : "";
                ?>
            </small>
        </div>
        <div class="form_group fields_toggle">
            <input name="submit" type="submit" value="UPLOAD" id="upload_btn">
        </div>
    </form>
</div>

<?php include 'partials/footer.php'; ?>