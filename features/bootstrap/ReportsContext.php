<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use BehatTests\helpers\Reports;
use BehatTests\helpers\Requesting;
use BehatTests\helpers\Reviews;
use BehatTests\helpers\Users;

class ReportsContext implements Context
{
    use Requesting, Users, Reviews, Reports;
}
