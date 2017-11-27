<?php namespace UKCASmith\Shipping\Couriers;

use UKCASmith\Shipping\Contracts\Consignment;

abstract class Courier
{
    protected static $consignmentNumbers = [];

    abstract public function add(Consignment $consignment);
    abstract public function send();

    /**
     * Reset consignment numbers.
     */
    public function reset() {
        static::$consignmentNumbers = [];
    }

    /**
     * Send e-mail.
     *
     * @param array $consignmentNumbers
     * @return string
     */
    protected function sendEmail(array $consignmentNumbers) {
        return 'email';
    }

    /**
     * Send ftp.
     *
     * @param array $consignmentNumbers
     * @return string
     */
    protected function sendFTP(array $consignmentNumbers) {
        return 'ftp';
    }

}