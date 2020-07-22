<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use BehatTests\helpers\Requesting;
use BehatTests\helpers\Users;

/**
 * Class AuthenticationContext
 * @package BehatTests
 */
class AuthenticationContext implements Context
{
    use Users, Requesting;
}
