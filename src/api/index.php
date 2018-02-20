<?php
require '../Include/Config.php';

// This file is generated by Composer
require_once dirname(__FILE__) . '/../vendor/autoload.php';

use ChurchCRM\Slim\Middleware\AuthMiddleware;
use ChurchCRM\Slim\Middleware\VersionMiddleware;
use Slim\App;
use Slim\Container;
use Slim\HttpCache\CacheProvider;

// Instantiate the app
$settings = require __DIR__ . '/../Include/slim/settings.php';

$container = new Container;
$container['cache'] = function () {
    return new CacheProvider();
};

// Add middleware to the application
$app = new App($container);

$app->add(new VersionMiddleware());
$app->add(new AuthMiddleware());

// Set up
require __DIR__ . '/dependencies.php';
require __DIR__ . '/../Include/slim/error-handler.php';

// calendar
require __DIR__ . '/routes/calendar/events.php';
require __DIR__ . '/routes/calendar/calendar.php';

// finance routes
require __DIR__ . '/routes/finance/finance-deposits.php';
require __DIR__ . '/routes/finance/finance-payments.php';

// People (families / persons)
require __DIR__ . '/routes/people/people-families.php';
require __DIR__ . '/routes/people/people-persons.php';
require __DIR__ . '/routes/people/people-properties.php';

// Public
require __DIR__ . '/routes/public/public.php';
require __DIR__ . '/routes/public/public-data.php';
require __DIR__ . '/routes/public/public-calendar.php';
require __DIR__ . '/routes/public/public-user.php';

// system routes
require __DIR__ . '/routes/system/system.php';
require __DIR__ . '/routes/system/system-custom-fields.php';
require __DIR__ . '/routes/system/system-database.php';
require __DIR__ . '/routes/system/system-issues.php';
require __DIR__ . '/routes/system/system-register.php';
require __DIR__ . '/routes/system/system-timerjobs.php';
require __DIR__ . '/routes/system/system-upgrade.php';

// other
require __DIR__ . '/routes/cart.php';
require __DIR__ . '/routes/dashboard.php';
require __DIR__ . '/routes/email.php';
require __DIR__ . '/routes/geocoder.php';
require __DIR__ . '/routes/groups.php';
require __DIR__ . '/routes/kiosks.php';
require __DIR__ . '/routes/roles.php';
require __DIR__ . '/routes/search.php';
require __DIR__ . '/routes/users.php';

// Run app
$app->run();
