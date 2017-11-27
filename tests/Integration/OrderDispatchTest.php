<?php

use PHPUnit\Framework\TestCase;
use UKCASmith\Shipping\OrderDispatch;
use UKCASmith\Shipping\Exceptions\OrderDispatchStatusIncorrect;
use UKCASmith\Shipping\Couriers\CourierFactory;
use UKCASmith\Shipping\Exceptions\NotAValidShippingCourier;

class OrderDispatchTest extends TestCase
{
    protected $orderDispatch;

    public function setUp()
    {
        parent::setUp();

        $this->orderDispatch = new OrderDispatch;
    }

    public function testOrderDispatchCanCorrectlyOpenedAndClosed()
    {
        $this->assertNull($this->orderDispatch->open());
        $this->assertNull($this->orderDispatch->close());
    }

    public function testOrderDispatchWillThrowWhenNotOpen()
    {
        $this->expectException(OrderDispatchStatusIncorrect::class);
        $this->orderDispatch->close();
    }

    public function testOrderDispatchWillThrowWhenNotClosed()
    {
        $this->expectException(OrderDispatchStatusIncorrect::class);
        $this->orderDispatch->open();
        $this->orderDispatch->open();
    }

    public function testOrderDispatchCanAddAssignments()
    {
        $order1 = (new ConsignmentOrder)->setCourierType(CourierFactory::ROYAL_MAIL);
        $order2 = (new ConsignmentOrder)->setCourierType(CourierFactory::ANC);

        $this->orderDispatch->open();
        $order1ConsignmentNumber = $this->orderDispatch->addConsignment($order1);
        $order2ConsignmentNumber = $this->orderDispatch->addConsignment($order2);

        $this->assertTrue(strlen($order1ConsignmentNumber) >= 64);
        $this->assertTrue(stripos($order1ConsignmentNumber, 'ROYALMAIL') !== false);

        $this->assertTrue(strlen($order2ConsignmentNumber) >= 64);
        $this->assertTrue(stripos($order2ConsignmentNumber, 'ANC') !== false);
        $this->orderDispatch->close();
    }

    public function testOrderDispatchWillThrowOnNonValidCourier()
    {
        $this->expectException(NotAValidShippingCourier::class);

        $order1 = (new ConsignmentOrder)->setCourierType(999);

        $this->orderDispatch->open();
        $this->orderDispatch->addConsignment($order1);
    }

    public function tearDown()
    {
        if ($this->orderDispatch->getBatchStatus()) {
            $this->orderDispatch->reset();
        }

        parent::tearDown();
    }
}