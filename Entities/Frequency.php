<?php

namespace Modules\Iplan\Entities;

/**
 * Class Status
 * @package Modules\Iplan\Entities
 */
class Frequency
{
    const DRAFT = 0;
    const PENDING = 1;
    const PUBLISHED = 2;
    const UNPUBLISHED = 3;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::DRAFT => trans('iplan::common.frequency.draft'),
            self::PENDING => trans('iplan::common.frequency.pending'),
            self::PUBLISHED => trans('iplan::common.frequency.published'),
            self::UNPUBLISHED => trans('iplan::common.frequency.unpublished'),
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists()
    {
        return $this->statuses;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::DRAFT];
    }
}
