<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public const TEST_LOGIN_URL = '/api/auth/login';
    public const TEST_LOGOUT_URL = '/api/auth/logout';
    public const TEST_REFRESH_TOKEN_URL = '/api/auth/refresh';
}
