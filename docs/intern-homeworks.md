# Intern homeworks API

## Get all homeworks
**Endpoint(GET):** /api/v1/me/homeworks?api_token=someToken

**Params list:** (option parameters are used for filtering)
+ api_token*
+ active - bool  (ex. 1)

Success response:
```json
{
    "success": true,
    "data": {
        "homeworks": [
            {
                "id": 5,
                "user_id": 2,
                "homework": {
                    "id": 6,
                    "name": "homework2",
                    "number": 2,
                    "course_id": 1,
                    "url": "",
                    "deadline": "2018-09-28 09:05:55",
                    "created_at": "2018-09-25 09:35:33"
                },
                "github_uri": "",
                "status": "",
                "started_at": "2018-09-25 12:35:33",
                "created_at": "2018-09-25 09:35:33"
            },
            {
                "id": 7,
                "user_id": 2,
                "homework": {
                    "id": 7,
                    "name": "homework3",
                    "number": 3,
                    "course_id": 1,
                    "url": "",
                    "deadline": "2018-09-28 09:05:55",
                    "created_at": "2018-09-25 09:47:57"
                },
                "github_uri": "",
                "status": "",
                "started_at": "2018-09-25 12:47:57",
                "created_at": "2018-09-25 09:47:57"
            }
        ]
    }
}
```
