<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use BehatTests\helpers\Requesting;

/**
 * Class RoutesContext
 * @package BehatTests
 */
class RoutesContext implements Context
{
    use Requesting;
}
