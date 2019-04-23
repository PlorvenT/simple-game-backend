@setup
    require __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    try {
        $dotenv->load();
    } catch ( Exception $e )  {
        echo $e->getMessage();
    }

    $sourcePath= __DIR__ . "/public/index.php";
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

    if [ ! -d {{$distPath}} ]; then
        mkdir {{$distPath}}
        chown -R www-data:www-data {{$distPath}}/*
        echo "{{$distPath}} Created"
    fi

    if [ ! -f {{$distPath}}/index.php ]; then
        ln -s {{$sourcePath}} {{$distPath}}/index.php
        echo "Symlink created from {{$sourcePath}} to {{$distPath}}/index.php"
    fi
@endtask

@macro('gitlab:deploy')
    migration
    symlink
@endmacro
