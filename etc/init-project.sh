# git
git submodule init
git submodule update
pushd ./laradock && git checkout 8254c3464743d86f42e9d7c83764bf3c385b6ad8
popd

# envのコピー
cat ./laradock/env-example ./etc/env-example > ./laradock/.env
cp ./etc/.env.example ./src/.env

# create database.
cp ./etc/grant-all-to-testing-database.sql ./laradock/mysql/docker-entrypoint-initdb.d

# docker up
pushd ./laradock
docker-compose build --no-cache nginx mysql workspace
docker-compose up -d nginx mysql workspace

# composer
docker-compose exec workspace composer install
docker-compose exec workspace composer run initialize

