# Internship courses API

## Get all internship courses
**Endpoint(GET):** /api/v1/courses?api_token=someToken

**User group access:** Employee only

**Params list:** (option parameters are used for filtering)
+ api_token*

Success response:
```json
{
    "success": true,
    "data": {
        "courses": [
            {
                "id": 1,
                "course": "FrontEnd2"
            },
            {
                "id": 2,
                "course": "BackEnd1"
            }
        ]
    }
}
```
