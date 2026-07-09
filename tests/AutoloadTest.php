<?php


declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Container;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Database;
use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Router;
use Omaressaouaf\PlainKit\Session;
use Omaressaouaf\PlainKit\Validator;
use Omaressaouaf\PlainKit\Exceptions\ValidationException;
use Omaressaouaf\PlainKit\Middleware\Auth;
use Omaressaouaf\PlainKit\Middleware\Guest;
use Omaressaouaf\PlainKit\Middleware\Middleware;
use Omaressaouaf\PlainKit\Middleware\VerifyCsrf;
use PHPUnit\Framework\TestCase;

class AutoloadTest extends TestCase
{
    public function test_package_classes_are_autoloadable(): void
    {
        $this->assertTrue(class_exists(App::class));
        $this->assertTrue(class_exists(Container::class));
        $this->assertTrue(class_exists(Router::class));
        $this->assertTrue(class_exists(Request::class));
        $this->assertTrue(class_exists(Response::class));
        $this->assertTrue(class_exists(Session::class));
        $this->assertTrue(class_exists(Validator::class));
        $this->assertTrue(class_exists(Database::class));
        $this->assertTrue(class_exists(Csrf::class));
        $this->assertTrue(class_exists(Authenticator::class));
        $this->assertTrue(class_exists(Form::class));
        $this->assertTrue(class_exists(ValidationException::class));
        $this->assertTrue(class_exists(Middleware::class));
        $this->assertTrue(class_exists(Auth::class));
        $this->assertTrue(class_exists(Guest::class));
        $this->assertTrue(class_exists(VerifyCsrf::class));
    }

    public function test_helper_functions_are_available(): void
    {
        $this->assertTrue(function_exists('base_path'));
        $this->assertTrue(function_exists('app_path'));
        $this->assertTrue(function_exists('load_env'));
        $this->assertTrue(function_exists('dd'));
        $this->assertTrue(function_exists('env'));
        $this->assertTrue(function_exists('e'));
        $this->assertTrue(function_exists('_r'));
    }
}
