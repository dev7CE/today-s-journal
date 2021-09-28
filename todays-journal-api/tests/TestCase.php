<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

// We dont use the class directly, just as 
// a extension. Every TestCase extends this class,
// so instead of modify headers in every single test
// we modify the request functions, by adding
// the JSON:API spect requiered headers.
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakesJsonApiRequest;
}
