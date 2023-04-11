<?php

namespace MyApp\classes;
use MyApp\classes\Product;

class Furniture extends Product {
  static protected $columns = ['id', 'sku', 'name', 'price', 'dimensions'];

  public function save() {
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO products (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ";
    $sql .= "(?, ?, ?, ?)";
    $stmt = self::$database->prepare($sql);
    $stmt->bind_param("ssds", $attributes['sku'], $attributes['name'], $attributes['price'], json_encode([$this->height, $this->width, $this->length]));
    $result = $stmt->execute();
    if($result) {
      $this->id = self::$database->insert_id;
    }
    $stmt->close();
    return $result;
  }

  public function __construct($args=[]) {
    $this->sku = $args['sku'] ?? '';
    $this->name = $args['name'] ?? '';
    $this->price = $args['price'] ?? '';
    $this->width = $args['width'] ?? '';
    $this->length = $args['length'] ?? '';
    $this->height = $args['height'] ?? '';
  }
}

?>