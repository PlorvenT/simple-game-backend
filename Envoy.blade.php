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
    php artisan config:cache
    php artisan migrate
@endtask

@task('symlink', ['on' => 'web'])
    echo 'Creating symlink';

    ln -s {{$indexSourcePath}} {{$distPath}}
    echo "Symlink created from {{$indexSourcePath}} to {{$distPath}}"

    chown -R www-data:www-data {{$sourcePath}}/public
    chown -R www-data:www-data {{$sourcePath}}/bootstrap/cache
    chown -R www-data:www-data {{$sourcePath}}/storage
@endtask

@macro('gitlab:deploy')
    migration
    symlink
@endmacro
