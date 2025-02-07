<?php

namespace Modules\Iplan\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Iplan\Repositories\SubscriptionRepository;

class CacheSubscriptionDecorator extends BaseCacheDecorator implements SubscriptionRepository
{
    public function __construct(SubscriptionRepository $subscription)
    {
        parent::__construct();
        $this->entityName = 'iplan.subscriptions';
        $this->repository = $subscription;
    }

  public function getItemsBy($params)
  {
    $this->clearCache();

    return $this->repository->getItemsBy($params);
  }

  public function getItem($criteria, $params = false)
  {
    $this->clearCache();

    return $this->repository->getItem($criteria, $params);
  }

  public function updateBy($criteria, $data, $params = false)
  {
    $this->clearCache();

    return $this->repository->updateBy($criteria, $data, $params);
  }

  public function deleteBy($criteria, $params = false)
  {
    $this->clearCache();

    return $this->repository->deleteBy($criteria, $params);
  }
}
