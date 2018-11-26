# Internship courses API

## Get all internship courses
**Endpoint(GET):** /api/v1/courses?api_token=someToken

**User group access:** Employee only

**Params list:**
+ api_token*

Success response:
```json
{
    "success": true,
    "data": {
        "courses": [
            {
                "id": 1,
                "course": "FrontEnd2",
                "leads": []
            },
            {
                "id": 2,
                "course": "BackEnd1",
                "leads": []
            }
        ]
    }
}
```
## Get course
**Endpoint(GET):** /api/v1/course/{course_id}?api_token=someToken

**Params list:**
+ api_token*
+ course_id*

Success response:
```json
{
    "success": true,
    "data": {
        "course": {
            "id": 2,
            "course": "BackEnd1",
            "leads": []
        }
    }
}
```
