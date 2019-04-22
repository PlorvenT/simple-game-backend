@servers(['web_prod' => 'localhost', 'web_dev' => 'localhost'])

@task('deploy:prod', ['on' => 'web_prod'])
    php artisan config:cache
    php artisan migrate
@endtask
