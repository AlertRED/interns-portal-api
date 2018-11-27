# Permissions API

## Get all possible permissions
**Endpoint(GET):** /api/v1/courses/all_permissions?api_token=someToken

**User group access:** Employee only

**Params list:**
+ api_token*

Success response:
```json
{
    "success": true,
    "data": {
        "permissions": {
            "ViewHomeworks": "Просмотр домашних заданий",
            "EditHomeworks": "Редактирование домашних заданий",
            "ChangeHomeworkStatuses": "Смена статусов домашних заданий"
        }
    }
}
```
## Get user permissions
**Endpoint(GET):** /api/v1/course/2/user/1/permissions?api_token=L3nS24eD6FJ1vlul1xGaweea0cUVzA

**Params list:**
+ api_token*
+ course_id* in url
+ user_id* in url

Success response:
```json
{
    "success": true,
    "data": {
        "permissions": {
            "ViewHomeworks": true,
            "EditHomeworks": false,
            "ChangeHomeworkStatuses": false
        }
    }
}
```

## Update user permissions
**Endpoint(GET):** /api/v1/course/2/user/1/permissions?api_token=L3nS24eD6FJ1vlul1xGaweea0cUVzA

**Params list:**
+ api_token*
+ course_id* in url
+ user_id* in url
+ permissions[] - array - possible values: 1/0
ex. 
permissions[ViewHomeworks] = 1

Success response:
```json
{
    "success": true,
    "data": {
        "permissions": {
            "ViewHomeworks": true,
            "EditHomeworks": false,
            "ChangeHomeworkStatuses": false
        }
    }
}
```
