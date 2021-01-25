# Cart-Microservice

Misses functionality to resolve cart state and misses some change validation.

Checking out might be extendend by publishing queue messages for another microservice to process it.

## Endpoints

### Change - make changes to cart

```
POST localhost/v1/cart/change  
{  
        "cart_id" : "e6804c81-0a96-4565-bca9-f2b8a2096f1a",  
        "item_id" : "d848ef34-5cee-11eb-ae93-0242ac131234",  
        "type" : "add",  
        "amount" : 10  
} 

Sample response 
{  
    "item_uuid": "d848ef34-5cee-11eb-ae93-0242ac131234",  
    "amount": 9,  
    "cart_change_type_id": 2,  
    "updated_at": "2021-01-25T09:40:30.000000Z",  
    "created_at": "2021-01-25T09:40:30.000000Z",  
    "cart": {  
        "checked_out": 0,  
        "uuid": "034959d0-64cd-4758-925d-d4f4307361a9",  
        "created_at": "2021-01-25T09:37:29.000000Z",  
        "updated_at": "2021-01-25T09:37:29.000000Z"  
    }  
}  

```

Allowed types: remove, add, checkout, revert_checkout


### Get Changes of Type removed - to know what was removed before checkout


```
GET localhost/v1/cart/e6804c81-0a96-4565-bca9-f2b8a2096f1a/changes/remove  

Sample response:  
[  
    {  
        "item_uuid": "d848ef34-5cee-11eb-ae93-0242ac131234",  
        "cart_change_type_id": 2,  
        "amount": 9,  
        "created_at": "2021-01-25T09:40:30.000000Z",  
        "updated_at": "2021-01-25T09:40:30.000000Z",  
        "cart_change_type": {  
            "type": "remove"  
        }  
    }  
]  
```

## HOW TO DEPLOY AND RUN TESTS

```
.vendor/bin/sail up

docker container exec -it cart-microservice_laravel.test_1 vendor/bin/phpunit

```

api will be available on localhost:80
