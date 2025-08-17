<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Product.php';
require_once __DIR__ . '/../app/core/Database.php';

class ProductTest extends TestCase
{
    private $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    public function testCreateProduct()
    {
        $result = $this->product->create("Test Product", 49.99, "Test description", "test.jpg");
        $this->assertTrue($result);
    }

    public function testGetAllProducts()
    {
        $products = $this->product->getAll();
        $this->assertIsArray($products);

        if (!empty($products)) {
            $this->assertArrayHasKey('id', $products[0]);
            $this->assertArrayHasKey('name', $products[0]);
            $this->assertArrayHasKey('price', $products[0]);
        }
    }

    public function testFindById()
    {
        $products = $this->product->getAll();
        if (!empty($products)) {
            $id = $products[0]['id'];
            $product = $this->product->findById($id);

            $this->assertIsArray($product);
            $this->assertEquals($id, $product['id']);
        } else {
            $this->markTestSkipped("No products found to test findById.");
        }
    }

    public function testUpdateProduct()
    {
        $products = $this->product->getAll();
        if (!empty($products)) {
            $id = $products[0]['id'];
            $result = $this->product->update($id, "Updated Product", 59.99, "Updated description");
            $this->assertTrue($result);
        } else {
            $this->markTestSkipped("No products available to test update.");
        }
    }

    public function testDeleteProduct()
    {
        $this->product->create("Temp Product", 10, "Temp desc", "temp.jpg");
        $products = $this->product->getAll();
        $lastProduct = end($products);

        $result = $this->product->delete($lastProduct['id']);
        $this->assertTrue($result);
    }
}
