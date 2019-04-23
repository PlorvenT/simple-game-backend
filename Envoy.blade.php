@setup
    require __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    try {
        $dotenv->load();
    } catch ( Exception $e )  {
        echo $e->getMessage();
    }

    $sourcePath= __DIR__ . "/public/index.php";
    $distPath = '/var/www/html/index.php';
    $server = getenv('DEPLOY_SERVER');
@endsetup

@servers(['web' => $server])

@task('migration', ['on' => 'web'])
    php artisan config:cache
    php artisan migrate
@endtask

@task('symlink', ['on' => 'web'])
    echo 'Creating symlink';
    ln -s {{$sourcePath}} {{$distPath}}
    echo "Symlink created from {{$sourcePath}} to {{$distPath}}"
@endtask

@macro('gitlab:deploy')
    migration
    symlink
@endmacro
