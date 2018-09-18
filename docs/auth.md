# Auth API

## Login
**Endpoint:** /api/v1/login

Params list:
+ login
+ password

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
        "api_token": "4eTSSt5HYtDzuNEBlOGVncmQcE8w8O"
    }
}
```

## Register
**Endpoint:** /api/v1/register

Example register link: http://internsportal.test/register?register_key=FWt4hI1tdiaoDaAtjP40

Params list: (* - required)
+ login*
+ email*
+ first_name*
+ last_name*
+ password*
+ register_key* from url

Failed request examples:
```json
{
    "success": false,
    "message": "Ключ уже использован"
}
```
```json
{
    "success": false,
    "message": "Неверный ключ регистрации"
}
```

Success response:
```json
{
    "success": true,
    "data": {
        "api_token": "4eTSSt5HYtDzuNEBlOGVncmQcE8w8O"
    }
}
```
