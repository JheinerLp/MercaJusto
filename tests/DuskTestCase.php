<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Preparar ChromeDriver antes de ejecutar tests.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * URL base de tu aplicación Laravel (IMPORTANTE PARA EVITAR ERR_CONNECTION_REFUSED)
     */
    protected function baseUrl(): string
    {
        return 'http://127.0.0.1:8000';
    }

    /**
     * Crear instancia del WebDriver.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(
            collect([
                '--window-size=1920,1080',
                '--disable-search-engine-choice-screen',
                '--disable-smooth-scrolling',
                '--no-sandbox',
                '--disable-dev-shm-usage',
            ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
                return $items->merge([
                    '--headless=new',
                    '--disable-gpu',
                ]);
            })->all()
        );

        return RemoteWebDriver::create(
            env('DUSK_DRIVER_URL', 'http://localhost:9515'),
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
}