<?php
declare(strict_types=1);
/**
 * ViperCMS.
 * 
 * @author Nicholas English <https://github.com/iszorpal>.
 * @link <https://github.com/iszorpal/vipercms>.
 */

namespace Viper;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Debug\Debug;

// Load all the composer packages.
require_once __DIR__ . '/vendor/autoload.php';

// Load the env configuration file.
(new Dotenv())->load(__DIR__ . '/.env');

// Determine if the application should be running in debug.
if ($_ENV['APP_DEBUG'])
{
    Debug::enable();
}

// Create a new application container.
$containerBuilder = new ContainerBuilder();

// Make the container accessable through a function.
function app(string $service)
{
    global $containerBuilder;
    if ($containerBuilder->has($service)) {
        return $containerBuilder->get($service);
    }
    throw new UnexpectedValueException('The service requested could not be found.');
}

// Initiate a new templating engine.
$filesystemLoader = new FilesystemLoader(__DIR__ . '/views/%name%');
$templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);

