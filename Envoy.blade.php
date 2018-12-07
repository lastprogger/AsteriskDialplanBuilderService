@servers(['prod' => ['root@37.46.132.164']])

@task('deploy', ['on' => 'prod'])
    cd /var/www/AsteriskDialplanBuilderService
    git pull
    composer install
    php artisan migrate:refresh --seed
    php artisan migrate:refresh --env=testing
    vendor/bin/phpunit
@endtask
