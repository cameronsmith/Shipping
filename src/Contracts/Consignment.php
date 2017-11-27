<?php namespace UKCASmith\Shipping\Contracts;

interface Consignment
{
    public function getCourierType();
    public function setCourierType($courierType);
}