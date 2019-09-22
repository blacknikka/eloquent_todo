# ToDoアプリ

## 概要
Eloquentを使ったTodoアプリ

## 初期化

```shell
git submodule init
git submodule update
bash ./etc/init-project.sh
```

## 実行

```shell
cd ./laradock
docker-compose up -d nginx mysql
```

## api
APIとして使用することができます。  
認証はAPIトークンを利用して行われます。

```bash
curl localhost/api/v1/comment/54?api_token=c5a89c32483a8cdbbf1e36d757821e66b2fa107cc8a09f91ebd4bb9918d93ed1
```

このようにAPIトークンを指定します  

response例

```bash
[{"user_id":{"id":109},"todo_id":{"id":54},"comment":"In eos ut animi assumenda inventore."},{"user_id":{"id":110},"todo_id":{"id":54},"comment":"Harum omnis rerum ullam ipsa qui veritatis et nam."},{"user_id":{"id":111},"todo_id":{"id":54},"comment":"Eveniet ad velit quasi quo incidunt nobis atque sint."},{"user_id":{"id":112},"todo_id":{"id":54},"comment":"Voluptas qui quia eum ipsa a aliquid aut."},{"user_id":{"id":113},"todo_id":{"id":54},"comment":"Dolore reiciendis voluptatem ut qui et vitae omnis quas qui aut et nihil."}]
```
