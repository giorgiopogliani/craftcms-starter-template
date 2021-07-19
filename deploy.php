<?php
namespace Deployer;
require 'recipe/common.php';

/**
 * Run a craft command.
 *
 * Supported options:
 *
 * @param string $command The craft command (with cli options if any).
 * @param array $options The options that define the behaviour of the command.
 * @return callable A function that can be used as a task.
 */
function craft($command, $options = []) 
{
    return function() use ($command, $options) {
        if (! test('[ -s {{release_path}}/.env ]')) {
            throw new \Exception('Your .env file is empty! Cannot proceed.');
        }

        $output = run("cd {{release_path}} && {{bin/php}} craft $command");
        
        if (in_array('showOutput', $options)) {
            writeln("<info>$output</info>");
        }
    };
}

/*
|--------------------------------------------------------------------------
| Setup Deploy
|--------------------------------------------------------------------------
*/

set('application', 'My New Website');
set('repository', '/path/to/github/repository'); // github repository
set('allow_anonymous_stats', false);
set('git_tty', false);
set('strategy', 'upload');

set('shared_dirs', [
    'storage', 
    'web/images',
    'web/uploads',
    // or any other directory 
]);

set('shared_files', [
    '.env',
     // or any other file
]);

set('writable_dirs', [
    'storage',
    'storage/runtime',
    'storage/logs',
    'storage/rebrand',
    'web/cpresources',
    'web/images',
    'web/uploads',
    // or any other directory 
]);

/*
|--------------------------------------------------------------------------
| Upload Options
|--------------------------------------------------------------------------
*/

set('upload_options', function () {
    $options = [
        '--exclude=.git',
        '--exclude=node_modules',
    ];
    return compact('options');
});

/*
|--------------------------------------------------------------------------
| Upload Task
|--------------------------------------------------------------------------
*/

desc('Upload a given folder to your hosts');
task('upload', function () {
    $configs = array_merge_recursive(get('upload_options'), [
        'options' => ['--delete']
    ]);
    upload( __DIR__ . '/', '{{release_path}}', $configs);
});

/*
|--------------------------------------------------------------------------
| Migrate Task
|--------------------------------------------------------------------------
| This task handle the migration of the craft database using the default
| enviroment options. This ensure there will not be errors loading 
| the website before any updated is completed.
*/

desc('Execute craft migrate');
task('craft:migrate', craft('migrate/all'))->once();

/*
|--------------------------------------------------------------------------
| Server Setup
|--------------------------------------------------------------------------
*/

host('my.host.name') 
    ->user('root') // remote server username 
    ->set('deploy_path', '/path/to/remote')
    ->set('branch', 'master');

/*
|--------------------------------------------------------------------------
| Deploy
|--------------------------------------------------------------------------
*/

desc('Upload Strategy');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'upload',
    'deploy:shared',
    'deploy:writable',
    'craft:migrate',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

