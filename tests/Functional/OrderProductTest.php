<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Order;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\OrderProduct;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class OrderProductTest extends KernelTestCase
{
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testNewProduct(): void
    {   
        $customer =  $this->entityManager->getRepository(User::class)
        ->findOneBy(['email' => 'abdaoui@jaafar.com']);

        $product =  $this->entityManager->getRepository(Product::class)
        ->findOneBy(['id' => 121]);
      
        $order = new Order();
        $order->setCustomer($customer);
        $order->setBillingName('test');
        $order->setBillingEmail('test@test.com');
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        
        $orderProducts = new OrderProduct();
        $orderProducts->setOrderId($order);
        $orderProducts->setProduct($product);
        $orderProducts->setQuantity(8);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        self::assertSame(8, $orderProducts->getQuantity());

    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

}