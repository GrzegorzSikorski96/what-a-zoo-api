<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use BehatTests\helpers\Requesting;
use BehatTests\helpers\Users;

class FeedContext implements Context
{
    use Requesting, Users;
}
