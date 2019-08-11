# envのコピー
cat ./laradock/env-example ./etc/laradock.env-example > ./laradock/.env
# cp ./etc/laravel.env.sample ./src/.env

# # docker up
pushd ./laradock
docker-compose build --no-cache nginx mysql workspace
docker-compose up -d nginx mysql workspace

# # composer
# docker-compose exec workspace composer install
# docker-compose exec workspace composer run initialize

