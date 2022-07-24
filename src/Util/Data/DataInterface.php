<?php

namespace App\Util\Data;

interface DataInterface
{
    /**
     * Set Order Id
     *
     * @param int $orderId
     * @return void
     */
    public function setOrderId(int $orderId): void;

    /**
     * Get Order Id
     *
     * @return int
     */
    public function getOrderId(): int;

    /**
     * Set Order Date Time
     *
     * @param string $orderDateTime
     * @return void
     */
    public function setOrderDateTime(string $orderDateTime): void;

    /**
     * Get Order Date Time
     *
     * @return string
     */
    public function getOrderDateTime(): string;

    /**
     * Set Total Order Value
     *
     * @param float $totalOrderValue
     * @return void
     */
    public function setTotalOrderValue(float $totalOrderValue): void;

    /**
     * Get Total Order Value
     *
     * @return float
     */
    public function getTotalOrderValue(): float;

    /**
     * Set Average Unit Price
     *
     * @param float $averageUnitPrice
     * @return void
     */
    public function setAverageUnitPrice(float $averageUnitPrice): void;

    /**
     * Get Average Unit Price
     *
     * @return float
     */
    public function getAverageUnitPrice(): float;

    /**
     * Set Distinct Unit Count
     *
     * @param int $distinctUnitCount
     * @return void
     */
    public function setDistinctUnitCount(int $distinctUnitCount): void;

    /**
     * Get Distinct Unit Count
     *
     * @return int
     */
    public function getDistinctUnitCount(): int;

    /**
     * Set Total Units Count
     *
     * @param int $totalUnitsCount
     * @return void
     */
    public function setTotalUnitsCount(int $totalUnitsCount): void;

    /**
     * Get Total Units Count
     *
     * @return int
     */
    public function getTotalUnitsCount(): int;

    /**
     * Set Customer State
     *
     * @param string $customerState
     * @return void
     */
    public function setCustomerState(string $customerState): void;

    /**
     * Get Customer State
     *
     * @return string
     */
    public function getCustomerState(): string;

    /**
     * Set Latitude
     *
     * @param float $latitude
     * @return void
     */
    public function setLatitude(float $latitude): void;

    /**
     * Get Latitude
     *
     * @return float
     */
    public function getLatitude(): float;

    /**
     * Set Longitude
     *
     * @param float $longitude
     * @return void
     */
    public function setLongitude(float $longitude): void;

    /**
     * Get Longitude
     *
     * @return float
     */
    public function getLongitude(): float;
}
