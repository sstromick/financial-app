# config valid only for current version of Capistrano
lock "3.16.0"

set :application, "reverb"
set :repo_url, "git@bitbucket.org:hopsie/apprisen-app.git"
set :deploy_to, "/var/www/app"
set :keep_releases, 5
set :use_sudo, false
set :composer_install_flags, '--no-interaction --optimize-autoloader'
SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

append :linked_dirs,
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs'

namespace :laravel do
    desc "Fix permissions"
    task :fix_permission do
        on roles(:laravel) do
            execute :chmod, "-R ug+rwx #{release_path}/bootstrap/cache/"
            execute :chgrp, "-R www-data #{release_path}/bootstrap/cache/"
        end
    end
    task :configure_dot_env do
    dotenv_file = fetch(:laravel_dotenv_file)
        on roles (:laravel) do
        execute :cp, "#{dotenv_file} #{release_path}/.env"
        end
    end
end

namespace :deploy do
    after :starting, "composer:install_executable"
    after :updated, "laravel:configure_dot_env"
end

