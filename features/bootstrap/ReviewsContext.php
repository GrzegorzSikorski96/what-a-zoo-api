<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use BehatTests\helpers\Requesting;
use BehatTests\helpers\Reviews;
use BehatTests\helpers\Users;
use BehatTests\helpers\Zoos;

class ReviewsContext implements Context
{
    use Requesting, Users, Zoos, Reviews;
}
