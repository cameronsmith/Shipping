<?php namespace UKCASmith\Shipping\Couriers;

use UKCASmith\Shipping\Couriers\Courier;
use UKCASmith\Shipping\Contracts\Consignment;

class ANC extends Courier
{
    /**
     * Add a consignment to courier.
     *
     * Note: We don't do anything with $consignmentOrder in this method, but in real life we would extract info like
     *       address, postcode, and etc.
     *
     * @param Consignment $consignmentOrder
     * @return string
     */
    public function add(Consignment $consignmentOrder) {
        $consignmentNumber = $this->getConsignmentNumber();
        static::$consignmentNumbers[] = $consignmentNumber;

        return $consignmentNumber;
    }

    /**
     * Send consignment numbers.
     *
     * @return string
     */
    public function send() {
        return $this->sendFtp(static::$consignmentNumbers);
    }

    /**
     * Get a consignment number.
     *
     * @return string
     */
    protected function getConsignmentNumber() {
        return 'ANC'.(bin2hex(random_bytes(64)));
    }
}