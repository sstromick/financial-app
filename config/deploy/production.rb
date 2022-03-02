server '192.241.183.171', user: 'hopsie', port: 22, roles: [:web, :app, :laravel, :composer], primary: true
set :branch, :master
set :laravel_dotenv_file, '/var/www/app/secrets/.env.production'