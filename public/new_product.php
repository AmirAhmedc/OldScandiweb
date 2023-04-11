<?php include_once '../private/initialize.php'; ?>
<?php

use MyApp\classes\Book;
use MyApp\classes\DVD;
use MyApp\classes\Furniture;
use MyApp\classes\Product;

$errors = validate_inputs($database);

if (isset($_POST['submit']) && empty($errors)) {
  $result = '';
  $args = [];
  $args['sku'] = $_POST['sku'] ?? null;
  $args['name'] = $_POST['name'] ?? null;
  $args['price'] = $_POST['price'] ?? null;
  $args['weight_kg'] = $_POST['weight_kg'] ?? null;
  $args['size'] = $_POST['size'] ?? null;
  $args['width'] = $_POST['width'] ?? null;
  $args['length'] = $_POST['length'] ?? null;
  $args['height'] = $_POST['height'] ?? null;

  if ($_POST['weight_kg'] != null) {
    $book = new Book($args);
    $result = $book->save();
  }

  if ($_POST['size'] != null) {
    $dvd = new DVD($args);
    $result = $dvd->save();
  }

  if ($_POST['width'] != null && $_POST['length'] != null && $_POST['height'] != null) {
    $furniture = new Furniture($args);
    $result = $furniture->save();
  }

  if ($result === true) {
    header('Location: index.php');
    exit;
  } else {
  }
}

?>
<!-- Have different page title for each page -->
<?php $page_title = 'Product Add'; ?>
<?php include '../private/shared/head.php'; ?>
<nav>
  <h1>Product Add</h1>
  <div id='form-buttons'>
    <button name='submit' id="submit" type="submit" class="btn" form='product_form' data-v-6374b2a8>Save</button>
    <a href="./index.php">
      <button type='button' class="btn btn-x" data-v-6374b2a8>Cancel</button>
    </a>
  </div>
</nav>
</header>
<hr>
<div class="container">
  <?= $errors; ?>
  <form action="" id='product_form' method='POST'>

    <div class="align-item">
      <label for="sku">SKU</label>
      <input type="text" name="sku" id='sku' class="form-control" placeholder="VKR12345" value="<?= $_POST['sku'] ?? ''; ?>">
    </div>
    <div class="align-item">
      <label for="name">Name</label>
      <input type="text" name='name' id='name' class="form-control" placeholder='Product name' value="<?= $_POST['name'] ?? ''; ?>">
    </div>
    <div class="align-item">
      <label for="price">Price ($)</label>
      <input type="text" name='price' id='price' class="form-control" placeholder="0.0" value="<?= $_POST['price'] ?? ''; ?>">
    </div>
    <div class="align-item">
      <label for="productType">Type Switcher</label>
      <select name="typeSwitcher" id="productType" class="form-select">
        <option value="dvd" id='DVD' <?= get_selected_type('dvd'); ?>>DVD</option>
        <option value="book" id='Book' <?= get_selected_type('book'); ?>>Book</option>
        <option value="furniture" id='Furniture' <?= get_selected_type('furniture'); ?>>Furniture</option>
      </select>
    </div>
    <div id='size-container'>
      <div class="align-item">
        <label for="size">Size (MB)</label>
        <input type="text" name='size' id='size' class="form-control" placeholder='0' maxlength='5' value="<?= $_POST['size'] ?? ''; ?>">
      </div>
      <div class="feedback">Please provide a size in megabyte (MB).</div>
    </div>
    <div id='weight-container'>
      <div class="align-item">
        <label for="weight">Weight (KG)</label>
        <input type="text" name='weight_kg' id='weight' class="form-control" placeholder='0.0' maxlength='3' value="<?= $_POST['weight_kg'] ?? ''; ?>">
      </div>
      <div class="feedback">Please provide a weight in kilograms (KG).</div>
    </div>
    <div id='dimensions-container'>
      <div class="align-item">
        <label for="height">Height (CM)</label>
        <input type="text" name='height' id='height' class="form-control" placeholder='0' maxlength='5' value="<?= $_POST['height'] ?? ''; ?>">
      </div>
      <div class="align-item">
        <label for="width">Width (CM)</label>
        <input type="text" name='width' id='width' class="form-control" placeholder='0' maxlength='5' value="<?= $_POST['width'] ?? ''; ?>">
      </div>
      <div class="align-item">
        <label for="length">Length (CM)</label>
        <input type="text" name='length' id='length' class="form-control" placeholder='0' maxlength='5' value="<?= $_POST['length'] ?? ''; ?>">
      </div>
      <div class="feedback">Please provide dimensions in HxWxL (height/width/length) format.</div>
    </div>
  </form>
  <?php include '../private/shared/footer.php'; ?>