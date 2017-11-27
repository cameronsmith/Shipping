<?php namespace UKCASmith\Shipping\Couriers;

use UKCASmith\Shipping\Exceptions\NotAValidShippingCourier;
use UKCASmith\Shipping\Couriers\RoyalMail;
use UKCASmith\Shipping\Couriers\ANC;

class CourierFactory
{
    /**
     * Shipping constants.
     */
    const ROYAL_MAIL = 1;
    const ANC = 2;

    /**
     * Return a class
     *
     * @param $courierType
     * @return \UKCASmith\Shipping\Couriers\ANC|\UKCASmith\Shipping\Couriers\RoyalMail
     * @throws NotAValidShippingCourier
     */
    public static function make($courierType) {
        switch ($courierType) {
            case static::ROYAL_MAIL:
                return new RoyalMail;
                break;

            case static::ANC:
                return new ANC;
                break;

            default:
                throw new NotAValidShippingCourier('A non valid courier type: ' . $courierType . ' was requested.');
        }
    }
}