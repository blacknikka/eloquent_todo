# envのコピー
cat ./laradock/env-example ./etc/laradock.env-example > ./laradock/.env
cp ./etc/laravel.env.sample ./src/.env

# create database.
cp ./etc/grant-all-to-testing-database.sql ./laradock/mysql/docker-entrypoint-initdb.d

# # docker up
pushd ./laradock
docker-compose build --no-cache nginx mysql workspace
docker-compose up -d nginx mysql workspace

# composer
docker-compose exec workspace composer install
docker-compose exec workspace composer run initialize

