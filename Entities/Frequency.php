<?php

namespace Modules\Iplan\Entities;

/**
 * Class Status
 */
class Frequency
{
  const UNIQUE = 0;

  const DIARY = 1;

  const WEEKLY = 8;

  const BIWEEKLY = 15;

  const MONTHLY = 30;

  const BIMONTHLY = 60;

  const QUARTERLY = 90;

  const BIANNUAL = 180;

  const ANNUAL = 365;

  /**
   * @var array
   */
  private $frequencies = [];

  public function __construct()
  {
    $this->frequencies = array_merge([
      ['id' => self::UNIQUE, 'title' => 'iplan::plans.frequencies.unique'],
      ['id' => self::DIARY, 'title' => 'iplan::plans.frequencies.diary'],
      ['id' => self::WEEKLY, 'title' => 'iplan::plans.frequencies.weekly'],
      ['id' => self::BIWEEKLY, 'title' => 'iplan::plans.frequencies.biweekly'],
      ['id' => self::MONTHLY, 'title' => 'iplan::plans.frequencies.monthly'],
      ['id' => self::BIMONTHLY, 'title' => 'iplan::plans.frequencies.bimonthly'],
      ['id' => self::QUARTERLY, 'title' => 'iplan::plans.frequencies.quarterly'],
      ['id' => self::BIANNUAL, 'title' => 'iplan::plans.frequencies.biannual'],
      ['id' => self::ANNUAL, 'title' => 'iplan::plans.frequencies.annual'],
    ], config("asgard.iplan.config.external-frequencies") ?? []);
  }

  /**
   * Get the available statuses
   */
  public function lists()
  {
    foreach ($this->frequencies as &$frequency) {
      $frequency['title'] = trans($frequency['title']);
    }
    return $this->frequencies;
  }

  /**
   * Get the post status
   *
   * @param int $statusId
   */
  public function get($frequencyId)
  {
    $frequencies = collect($this->frequencies);
    $frequency = $frequencies->where('id', $frequencyId)->first() ?? $frequencies->where('id', self::MONTHLY)->first();

    return trans($frequency['title']);
  }
}
