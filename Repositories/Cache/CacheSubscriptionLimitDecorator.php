<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Iplan\Repositories\SubscriptionLimitRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSubscriptionLimitDecorator extends BaseCacheDecorator implements SubscriptionLimitRepository
{
    public function __construct(SubscriptionLimitRepository $subscriptionlimit)
    {
        parent::__construct();
        $this->entityName = 'iplan.subscriptionlimits';
        $this->repository = $subscriptionlimit;
    }

  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }

  public function getItem($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }


  public function updateBy($criteria, $data, $params = false)
  {
    return $this->remember(function () use ($criteria, $data, $params) {
      return $this->repository->updateBy($criteria, $data, $params);
    });
  }

  public function deleteBy($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->deleteBy($criteria, $params);
    });
  }
}
