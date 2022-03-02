server '162.243.1.205', user: 'hopsie', port: 22, roles: [:web, :app, :laravel, :composer], primary: true
set :branch, :staging
set :laravel_dotenv_file, '/var/www/app/secrets/.env.production'