@setup
    require __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    try {
        $dotenv->load();
    } catch ( Exception $e )  {
        echo $e->getMessage();
    }

    $server = getenv('DEPLOY_SERVER');
@endsetup

@servers(['web' => $server])

@task('deploy:prod', ['on' => 'web'])
    echo $server
    php artisan config:cache
    php artisan migrate
@endtask
