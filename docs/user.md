# User API

## Get user
**Endpoint(GET):** /api/v1/user/{id}/get?api_token=someToken

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
