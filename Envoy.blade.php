@setup
    require __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    try {
        $dotenv->load();
    } catch ( Exception $e )  {
        echo $e->getMessage();
    }

    $sourcePath = __DIR__;
    $indexSourcePath = $sourcePath . "/public/";
    $distPath = '/var/www/html';
    $server = getenv('DEPLOY_SERVER');
@endsetup

@servers(['web' => $server])

@task('migration', ['on' => 'web'])
    php artisan migrate
@endtask

@task('config:cache', ['on' => 'web'])
    php artisan config:cache
@endtask

@task('generate:key', ['on' => 'web'])
    php artisan key:generate
@endtask

@task('symlink', ['on' => 'web'])
    chmod -R 777 {{$sourcePath}}/public
    chmod -R 777 {{$sourcePath}}/bootstrap/cache
    chmod -R 777 {{$sourcePath}}/storage

    echo 'Creating symlink';

    ln -s {{$indexSourcePath}} {{$distPath}}
    echo "Symlink created from {{$indexSourcePath}} to {{$distPath}}"
@endtask

@macro('gitlab:deploy')
    migration
    generate:key
    config:cache
    symlink
@endmacro
