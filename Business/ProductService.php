<?php

declare(strict_types=1);

namespace Business;

use Data\ProductDAO;
use Entities\Product;
use Exceptions\noProductsFoundException;

class ProductService
{
   private ProductDAO $productDAO;

   public function __construct()
   {
      $this->productDAO = new ProductDAO();
   }

   public function getAllProducts(): array
   {
      $records = $this->productDAO->getAllProducts();

      if (!$records) {
         throw new noProductsFoundException();
      }

      $products = [];

      foreach ($records as $record) {

         $products[] = new Product((int)$record['id'], $record['name'], (float)$record['price'], $record['img'], $record['description']);
      }

      return $products;
   }

   public function getProductById(int $id): Product
   {
      $record = $this->productDAO->getProductById($id);

      if (!$record) {
         throw new noProductsFoundException();
      }

      $product = new Product((int)$record['id'], $record['name'], (float)$record['price'], $record['img'], $record['description']);
      return $product;
   }
}
