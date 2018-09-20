# Me (current user) API

## Get my profile info
**Endpoint(GET):** /api/v1/me/profile_info/get?api_token=someToken

Params list:
+ api_token*

Failed request examples:
```json
{
    "message": "Unauthorized"
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

## Edit my profile info
**Endpoint(PUT):** /api/v1/me/profile_info/edit?api_token=someToken

Params list:
+ api_token*
+ login
+ email
+ first_name
+ last_name
+ password

Failed request examples:
```json
{
    "message": "Unauthorized"
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
