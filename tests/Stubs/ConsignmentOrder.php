<?php

use UKCASmith\Shipping\Contracts\Consignment;

class ConsignmentOrder implements Consignment
{
    protected $courierType = 0;

    /**
     * Return the courierType.
     *
     * @return int
     */
    public function getCourierType()
    {
        return $this->courierType;
    }

    /**
     * Set the courierType.
     *
     * @param $courierType
     * @return $this
     */
    public function setCourierType($courierType)
    {
       $this->courierType = $courierType;

       return $this;
    }
}