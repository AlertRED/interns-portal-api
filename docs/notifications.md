# Notifications API

## Get my profile info
**Endpoint(GET):** /api/v1/me/notifications?api_token=someToken

Params list:
+ api_token*

Дополнения:
+ лимит - 10 оповещений
+ сортируются сперва по created_at затем по seen (сперва непросмотренные)

Success response example:
```json
{
    "success": true,
    "data": {
        "notifications": [
            {
                "id": 2,
                "user_id": 1,
                "title": "title",
                "seen": false,
                "text": "hey",
                "uri": "/",
                "created_at": "2018-10-20 18:51:55"
            },
            {
                "id": 1,
                "user_id": 1,
                "title": "title here",
                "seen": true,
                "text": "title here",
                "uri": "/",
                "created_at": "2018-10-20 18:30:18"
            },
            {
                "id": 3,
                "user_id": 1,
                "title": "titl",
                "seen": true,
                "text": "heyyy",
                "uri": "/",
                "created_at": "2018-10-20 16:14:54"
            }
        ]
    }
}
```

## Get my profile info
**Endpoint(PATCH):** /api/v1/me/notifications/seen_all?api_token=someToken

Params list:
+ api_token*

Дополнения:
+ выставляет всем оповещениям юзера seen = true
