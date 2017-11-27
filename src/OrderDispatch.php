<?php namespace UKCASmith\Shipping;

use UKCASmith\Shipping\Couriers\CourierFactory;
use UKCASmith\Shipping\Exceptions\OrderDispatchStatusIncorrect;
use UKCASmith\Shipping\Contracts\Consignment;

class OrderDispatch
{
    /**
     * Current state of batch.
     *
     * @var bool
     */
    protected static $batchStatus = false;

    /**
     * List of shipping couriers
     *
     * @var array
     */
    protected static $shipments = [];

    /**
     * Open a new batch
     *
     * @throws OrderDispatchStatusIncorrect
     */
    public function open()
    {
        if (static::$batchStatus) {
            throw new OrderDispatchStatusIncorrect('Order dispatch is already open.');
        }

        static::$batchStatus = true;
    }

    /**
     * Get batch status
     *
     * @return bool
     */
    public function getBatchStatus()
    {
        return static::$batchStatus;
    }

    /**
     * Add a consignment and return the consignment number.
     *
     * @param Consignment $consignment
     * @return string
     */
    public function addConsignment(Consignment $consignment)
    {
        $courierType = $consignment->getCourierType();
        $courier = CourierFactory::make($courierType);

        if (!in_array($courierType, static::$shipments)) {
            static::$shipments[] = $courierType;
        }

        return $courier->add($consignment);
    }

    /**
     * Close an existing batch.
     *
     * @throws OrderDispatchStatusIncorrect
     */
    public function close()
    {
        if (!static::$batchStatus) {
            throw new OrderDispatchStatusIncorrect('Order dispatch is already closed.');
        }

        $this->sendConsignments(static::$shipments);
        static::$batchStatus = false;
    }

    /**
     * Reset - clear all static variables within this class and the couriers.
     */
    public function reset()
    {
        foreach (static::$shipments as $courier) {
            CourierFactory::make($courier)->reset();
        }

        static::$shipments = [];
        static::$batchStatus = false;
    }

    /**
     * Send consignments via each courier.
     *
     * @param $shipments
     */
    protected function sendConsignments(array $shipments)
    {
        foreach ($shipments as $courier) {
            CourierFactory::make($courier)->send();
        }
    }
}