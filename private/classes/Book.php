<?php

namespace MyApp\classes;
use MyApp\classes\Product;

class Book extends Product {

  static protected $columns = ['id', 'sku', 'name', 'price', 'weight_kg'];

  public function __construct($args=[]) {
    $this->sku = $args['sku'] ?? '';
    $this->name = $args['name'] ?? '';
    $this->price = $args['price'] ?? '';
    $this->weight_kg = $args['weight_kg'] ?? '';
  }
}

?>