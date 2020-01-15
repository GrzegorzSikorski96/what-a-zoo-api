<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService
{
    protected $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }
}
