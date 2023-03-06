<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Order;

class OrderTest extends TestCase
{
    public function testNewOrder(): void
    {
        $order = new Order();
        $order->setBillingName('test billing');
        $order->setBillingEmail('test@billnig.com');

        self::assertSame('test billing', $order->getBillingName());
        self::assertSame('test@billnig.com', $order->getBillingEmail());

    }

}