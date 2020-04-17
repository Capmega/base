<?php
namespace Capmega\Base;

use Illuminate\Support\ServiceProvider;
use Capmega\Blog\Models\BlogKey;
use Illuminate\Database\Schema\Blueprint;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('commonFields', function () {
            $this->smallInteger('status')->default('15');
            $this->unsignedBigInteger('created_by')->unsigned()->index()->nullable();
            $this->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $this->unsignedBigInteger('updated_by')->unsigned()->index()->nullable();
            $this->foreign('updated_by')->references('id')->on('users')->onDelete('restrict');
            $this->unsignedBigInteger('deleted_by')->unsigned()->index()->nullable();
            $this->foreign('deleted_by')->references('id')->on('users')->onDelete('restrict');
            $this->string('deleted_reason')->nullable();
            $this->timestamp('deleted_at')->nullable();
        });

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../views', 'base');
        $this->loadTranslationsFrom(__DIR__.'/../translations', 'base');
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->app['router']->aliasMiddleware('admin', \Capmega\Base\Middleware\Admin::class);

        // $this->publishes([
        //     __DIR__.'/../resources/atlant' => public_path('vendor/base'),
        // ], 'public');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/base'),
            __DIR__.'/../config/base.php' => config_path('base.php'),
            __DIR__.'/../translations' => resource_path('lang/vendor/base'),
        ]);

        $this->registerBladeExtensions();

        $this->commands([
            \Capmega\Base\Commands\ModelMakeCommand::class,
            \Capmega\Base\Commands\MigrateMakeCommand::class,
            \Capmega\Base\Commands\ClearImages::class,
            \Capmega\Base\Commands\ConverImages::class,
            \Capmega\Base\Commands\UpdateModel::class,
            \Capmega\Base\Commands\Backups\MysqlBackup::class,
            \Capmega\Base\Commands\Backups\SyncServer::class,
            \Capmega\Base\Commands\Backups\SendToServer::class,
            \Capmega\Base\Commands\Backups\MysqlMount::class,
            \Capmega\Base\Commands\Deploy::class,
            \Capmega\Base\Commands\DeployUnlock::class
        ]);

        if (!$this->app->runningInConsole()) {
            $configuration = BlogKey::select('seoname', 'value')->where('blog_post_id', 1)->get()->keyBy('seoname')->toArray();
            // \Config::set('configuration', $configuration);

            view()->composer('*', function($view) use ($configuration){
                $view->with('configuration', $configuration);
            });
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/base.php', 'base'
        );

        $this->app->extend('command.model.make', function ($command, $app) {
            return new \Capmega\Base\Commands\ModelMakeCommand($app['files']);
        });

        // foreach (glob(app_path().'/Helpers/*.php') as $filename){
        //     require_once($filename);
        // }

        // require_once(__DIR__.'/../helpers/helpers.php');

        // $this->app->singleton('command.migrate.base.make', function ($app) {
        //     // Once we have the migration creator registered, we will create the command
        //     // and inject the creator. The creator is responsible for the actual file
        //     // creation of the migrations, and may be extended by these developers.
        //     $creator = $app['migration.creator'];
        //
        //     $composer = $app['composer'];
        //
        //     return new \Capmega\Base\Commands\MigrateMakeCommand($creator, $composer);
        // });
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->directive('card', function ($title = '') {
            return '<div class="card">
                        <h3 class="card-header">'.$title.'</h3>
                        <div class="card-body">
            ';
        });
        $blade->directive('endcard', function () {
            return '    </div>
                    </div>';
        });
    }
}
