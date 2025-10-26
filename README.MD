# Test Task: Tariff plans

The test task involves creating tariff plans, filtering obscene words, processing descriptions, adding logs when saving and sending messages to the administrator.
One of the requirements of the task is not to use a framework.

## How it Works

`server/app/src/Service/TariffService.php` - is the main service for managing tariff plans

`server/app/src/Util/TariffDescriptionHandler.php` - description processing

The test project uses two* external dependencies:
1. symfony/validator
2. symfony/serializer
3. (symfony/property-access) - also for serializer

## Config
`server/app/src/Config.php` - configuration file

## Database Schema
Check the database schema in `schema/schema.sql`


## Usage
To run the project, use the following command:
```
docker compose up -d
```
Use requests.http for real API testing.

You can also use a Postman (or other) or cUrl for testing

Postman: `http://localhost:31/tariff` - main link

Create: POST

Body
```
{
    "typeId": 1,
    "name": "Tariff Name",
    "description": "Tariff Description https://ya.ru/ <img src=\"https://images.pexels.com/photos/18254876/pexels-photo-18254876.jpeg\">  word1 word2 текст текст плохое слово1 плохое слово2 описание",
    "price": 10.99,
    "is_active": true
}
```

Select: GET 

`http://localhost:31/tariff?id=1` (example)

Update: PUT

`http://localhost:31/tariff?id=1`

Body
```
{
    "id": 1,
    "typeId": 1,
    "name": "Updated Name",
    "description": "Tariff Description https://ya.ru/ <img src=\"https://images.pexels.com/photos/18254876/pexels-photo-18254876.jpeg\">  word1 word2 текст текст плохое слово1 плохое слово2 описание",
    "price": 10.99,
    "is_active": false
}
```

Delete: DELETE

`http://localhost:31/tariff?id=1`


## CURL commands

Create

```
curl -X POST \
nginx_tariffs/tariff \
-H 'Content-Type: application/json' \
-d '{
"typeId": 1,
"name": "Tariff Name",
"description": "Tariff Description https://ya.ru/ <img src=\"https://images.pexels.com/photos/18254876/pexels-photo-18254876.jpeg\">  word1 word2 текст текст плохое слово1 плохое слово2 описание",
"price": 10.99,
"is_active": true
}'
```

Select

```
curl -X GET "nginx_tariffs/tariff?id=1"
```

Update

```
curl -X PUT \
nginx_tariffs/tariff \
-H 'Content-Type: application/json' \
-d '{
"id": 1,
"typeId": 1,
"name": "Updated Name",
"description": "Tariff Description https://ya.ru/ <img src=\"https://images.pexels.com/photos/18254876/pexels-photo-18254876.jpeg\">  word1 word2 текст текст плохое слово1 плохое слово2 описание",
"price": 10.99,
"is_active": false
}'
```

Delete

```
curl -X DELETE "http://your-api-domain.com/tariff?id=1"
```
