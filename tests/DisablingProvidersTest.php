<?php


namespace Inspector\Laravel\Tests;


use Inspector\Laravel\Providers\DatabaseQueryServiceProvider;
use Inspector\Laravel\Providers\EmailServiceProvider;
use Inspector\Laravel\Providers\JobServiceProvider;
use Inspector\Laravel\Providers\UnhandledExceptionServiceProvider;

class DisablingProvidersTest extends BasicTestCase
{
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('inspector.job', false);
        $app['config']->set('inspector.query', false);
        $app['config']->set('inspector.email', false);
        $app['config']->set('inspector.unhandled_exceptions', false);
    }

    public function testBindingDisabled()
    {
        // Bind Inspector service
        $this->assertInstanceOf(\Inspector\Inspector::class, $this->app['inspector']);

        // Nor register service providers
        $this->assertNull($this->app->getProvider(JobServiceProvider::class));
        $this->assertNull($this->app->getProvider(DatabaseQueryServiceProvider::class));
        $this->assertNull($this->app->getProvider(EmailServiceProvider::class));
        $this->assertNull($this->app->getProvider(UnhandledExceptionServiceProvider::class));
    }
}