# Homeworks API

## Get all homeworks
**Endpoint(GET):** /api/v1/homeworks?api_token=someToken

**Group access:** Employee

**Params list:** (each parameter is optional and can be used as filter)
+ api_token*
+ course (ex. FrontEnd2)

Success response:
```json
{
    "success": true,
    "data": {
        "homeworks": [
            {
                "id": 1,
                "name": "testHomework",
                "number": 12,
                "course_id": 1,
                "url": "",
                "deadline": "2018-09-24 14:46:41",
                "created_at": "2018-09-25 08:16:29"
            },
            {
                "id": 2,
                "name": "testHomework2",
                "number": 12,
                "course_id": 1,
                "url": "",
                "deadline": "2018-09-24 14:46:41",
                "created_at": "2018-09-25 08:16:33"
            }
        ]
    }
}
```

## Get homework by id
**Endpoint(GET):** /api/v1/homework/{id}?api_token=someToken

**Group access:** Employee

**Params list:**
+ api_token*
+ id*

Success response:
```json
{
    "success": true,
    "data": {
        "homework": {
            "id": 2,
            "name": "testHomework1",
            "number": 12,
            "course_id": 1,
            "url": "",
            "deadline": "2018-09-24 14:46:41",
            "created_at": "2018-09-25 08:23:55"
        }
    }
}
```

## Create homework
**Endpoint(POST):** /api/v1/homework?api_token=someToken

**Group access:** Employee

**Params list:**
+ api_token*
+ name*
+ number*
+ course_id* (id in internship_courses table)
+ deadline* (ex. "2018-09-24 14:46:41")
+ url

Success response:
```json
{
    "success": true,
    "data": {
        "homework": {
            "id": 2,
            "name": "testHomework1",
            "number": 12,
            "course_id": 1,
            "url": "",
            "deadline": "2018-09-24 14:46:41",
            "created_at": "2018-09-25 08:23:55"
        }
    }
}
```

## Edit homework
**Endpoint(PATCH):** /api/v1/homework/{id}?api_token=someToken

**Group access:** Employee

**Params list:**
+ id*
+ api_token*
+ name
+ number
+ course_id (id in internship_courses table)
+ deadline (ex. "2018-09-24 14:46:41")
+ url

Success response:
```json
{
    "success": true,
    "data": {
        "homework": {
            "id": 2,
            "name": "testHomework1",
            "number": 12,
            "course_id": 1,
            "url": "",
            "deadline": "2018-09-24 14:46:41",
            "created_at": "2018-09-25 08:23:55"
        }
    }
}
```
