<?php

use MyApp\classes\Product;

include_once '../private/initialize.php';

$products = Product::select_all();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteId'])) {
    $selected = $_POST['deleteId'];
    Product::delete($selected);
}

?>


<!-- Have different page title for each page -->
<?php $page_title = 'Product List';?>
<?php include '../private/shared/head.php';?>

<nav>
  <h1>Product List</h1>
  <div id='nav-buttons'>
    <a href="./new_product.php"><button id='add-product-btn' class="btn" type='button'>ADD</button></a>
    <button id='delete-product-btn' class="btn" form='product_list' type='submit' name='delete'>MASS DELETE</button>
  </div>
</nav>
</header>
<hr>
<div class="container">
  <!-- Get all the products from the database and display them -->
  <form action="" id='product_list' method='POST'>
    <div class="row">
      <?php foreach ($products as $product) {?>
        <div class="col-6 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="form-check">
                <input type="checkbox" name="deleteId[]" value="<?=$product->id?>" class="delete-checkbox">
              </div>
              <div class='product-info'>

                <p class="card-title"><?=$product->id;?></p>
                <p class="card-title"><?=$product->sku;?></p>
                <p class="card-title"><?=$product->name;?></p>
                <p class="card-title"><?=$product->price;?></p>
                <p class="card-title">
                  <?php

                    echo $product->weight_kg != 0.0 ? "Weight: " . $product->weight_kg . "KG" : '';

                    echo $product->size != 0 ? "Size: " . $product->size . "MB" : '';
                    echo $product->dimensions != "" ? "Dimensions: " . extract_from_database_array($product->dimensions) : '';
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      <?php }
;?>
    </div>
  </form>
  <?php include '../private/shared/footer.php';?>