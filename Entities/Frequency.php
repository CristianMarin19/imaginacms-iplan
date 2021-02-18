<?php

namespace Modules\Iplan\Entities;

/**
 * Class Status
 * @package Modules\Iplan\Entities
 */
class Frequency
{
    const WEEKLY = 8;
    const BIWEEKLY = 15;
    const MONTHLY = 30;

    /**
     * @var array
     */
    private $frequencies = [];

    public function __construct()
    {
        $this->frequencies = [
            ['id' => self::WEEKLY, 'title' => trans('iplan::plans.frequencies.weekly')],
            ['id' => self::BIWEEKLY, 'title' => trans('iplan::plans.frequencies.biweekly')],
            ['id' => self::MONTHLY, 'title' =>  trans('iplan::plans.frequencies.monthly')],
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists()
    {
        return $this->frequencies;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get($frequencyId)
    {
        if (isset($this->frequencies[$frequencyId])) {
            return $this->frequencies[$frequencyId];
        }

        return $this->frequencies[self::WEEKLY];
    }
}
