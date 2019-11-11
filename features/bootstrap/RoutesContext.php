<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use BehatTests\helpers\Requesting;

class RoutesContext implements Context
{
    use Requesting;
}
