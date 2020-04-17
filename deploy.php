<?php

namespace Deployer;

require 'recipe/laravel.php';

// Tasks

//Generate optimize bundles
task('fix:npm_build', function () {
    run('npm run build:back');
    run('npm run build:front');
})->local();

//Send optimize functions
task('fix:npm_send', function () {
    upload("public/bundle-back.js", '{{release_path}}/public/bundle-back.js');
    upload("public/bundle-front.js", '{{release_path}}/public/bundle-front.js');
});

//Send optimize functions
task('fix:template_send', function () {
    upload("public/app-assets/", '{{release_path}}/public/app-assets/');
});

//Fixed user-own
task('fix:permisions', function () {
    run('sudo chown www-data:www-data {{release_path}}/../../ -R');
});

//Fixed user-own before
task('fix:permisions_before', function () {
    run('sudo chown ${USER}:${USER} {{release_path}}/../../ -R');
});

//Group Fix
task('fix', [
    'fix:npm_build',
    'fix:permisions_before',
    'fix:npm_send',
    'fix:template_send',
    'fix:permisions',
]);

task('build', function () {
    run('cd {{release_path}} && build');
});

//Group Fix
task('sdk-deploy', [
    'deploy',
    'fix',
]);

//Global config
set('http_user', 'www-data');

// set permisions
set('writable_use_sudo', true);
set('clear_use_sudo', true);
set('cleanup_use_sudo', true);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

//back to previus release
// task('npm', function () {
//     if (has('previous_release')) {
//         run('cp -R {{previous_release}}/node_modules {{release_path}}/node_modules');
//     }
//
//     run('cd {{release_path}} && npm install');
// });

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

// add('shared_files', ['public/app-assets']);
add('shared_dirs', ['public/app-assets']);

// Hosts
/* Example
host('capmega.com')
    ->stage('production')
    // ->set('user', 'www-data')
    ->port(22)
    ->set('deploy_path', '/var/www/html/{{application}}');

host('trial.capmega.com')
    ->stage('staging')
    // ->set('user', 'www-data')
    ->port(22)
    ->set('deploy_path', '/var/www/html/{{application}}');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
*/
