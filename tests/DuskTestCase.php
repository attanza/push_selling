<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        // return RemoteWebDriver::create(
        //     'http://push_selling.dev:9515', DesiredCapabilities::chrome()
        // );
        $chrome = DesiredCapabilities::chrome();
        if (config('app.env_docker')) {
            $chrome->setCapability(
                ChromeOptions::CAPABILITY,
                (new ChromeOptions)->addArguments(['--no-sandbox'])
            );
        }
        return RemoteWebDriver::create('http://push_selling.dev:9515', $chrome);

    }
}
