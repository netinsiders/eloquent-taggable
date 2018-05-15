<?php namespace Cviebrock\EloquentTaggable;

use Cviebrock\EloquentTaggable\Services\TagService;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Cviebrock\EloquentTaggable
 */
class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../resources/config/taggable.php' => config_path('taggable.php'),
        ], 'config');

        if (!class_exists('CreateTaggableTable')) {
            // Publish the migration
            $src = __DIR__ . '/../resources/database/migrations/2017_01_17_000000_create_taggable_table.php';

            $this->publishes([
                $src => database_path('/migrations'),
            ], 'migrations');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/taggable.php', 'taggable');

        $this->app->singleton(TagService::class);
    }
}
