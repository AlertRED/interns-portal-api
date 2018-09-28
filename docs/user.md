# User API

## Get user
**Endpoint(GET):** /api/v1/user/{id}?api_token=someToken

**User group access:** Employee only

Params list:
+ id*
+ api_token*

Failed request examples:
```json
{
    "success": false,
    "message": "Пользователь не существует"
}
```

Success response:
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "email": "user2@bk.ru",
            "login": "user2",
            "first_name": "Alex",
            "last_name": "Popov",
            "course": "FrontEnd2",
            "role": "User",
            "register_date": "2018-09-18 08:18:08"
        }
    }
}
```

## Get interns
**Endpoint(GET):** /api/v1/interns?api_token=someToken

**User group access:** Employee only


Params list:
+ api_token*

Success response:
```json
{
    "success": true,
    "data": {
        "users": [
            {
                "id": 2,
                "email": "intern@rt.de",
                "login": "intern1",
                "first_name": "Alex",
                "last_name": "Fedorov",
                "course": "FrontEnd2",
                "role": "User",
                "register_date": ""
            },
            {
                "id": 3,
                "email": "intern2@rt.de",
                "login": "intern2",
                "first_name": "Ivan",
                "last_name": "Ivanov",
                "course": "FrontEnd2",
                "role": "User",
                "register_date": ""
            }
        ]
    }
}
```
