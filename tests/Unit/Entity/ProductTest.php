<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function testNewProduct(): void
    {
        $product = new Product();
        $product->setName('testP');
        $product->setPrice(1000);

        self::assertSame('testP', $product->getName());
        self::assertSame(1000, $product->getPrice());

    }

}