# Project: Today's Journal API
API built under JSON:API Specification. To learn more about this spec [visit the official docs](https://jsonapi.org/format/)

## Installation


* Download or clone the project
* Install composer dependences: 

```bash
  composer install
```
* Create a copy of `env.example` file.
    * In this file, change database connection variables. 
* Generate app encryption key:
```bash
  php artisan key:generate
```
* Create an empty database with the name of the given database name in  `.env` file.
* Migrate the database with seedings:
```bash
  php artisan migrate --seed
```
* Run application:
```bash
  php artisan serve
```

## Usage

Create new request based on this documentation, or import the postman collection and enviroment files located in ['~/postman-files'](https://github.com/dev7CE/today-s-journal/tree/master/postman-files) folder 

# 📁 Collection: Authentication 


## End-point: Login - Mobile Application (Token)
This login use a `multipart/form` and return a json response with bearer `plain_text_token` value.
### Method: POST
>```
>http://localhost:8000/api/v1/login
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Headers

|Content-Type|Value|
|---|---|
|Content-Type|multipart/form-data|


### Body formdata

|Param|value|Type|
|---|---|---|
|email|loremi@email.com|text|
|password|password|text|
|device_name|MyDevice|text|


### 🔑 Authentication 

No Auth


### Response: 201
```json
{
    "plain_text_token": "1|4HSoTcSmVSwLLL1T1MnGtBHhh5ZjS1teZ0VwcJBE"
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃
# 📁 Collection: Stories 


## End-point: List Stories
This request show **all exiting stories**. No authentication is needed.
### Method: GET
>```
>http://localhost:8000/api/v1/stories/
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Response: 200
```json
{
    "data": [
        {
            "type": "stories",
            "id": "story-1",
            "attributes": {
                "title": "Story 1",
                "url": "story-1",
                "content": "9woPyLiXQ8"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-1"
            }
        },
        {
            "type": "stories",
            "id": "story-2",
            "attributes": {
                "title": "Story 2",
                "url": "story-2",
                "content": "ACkYdHsZ9P"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-2"
            }
        }
    ],
    "links": {
        "self": "http://localhost:8000/api/v1/stories",
        "first": "http://localhost:8000/api/v1/stories?page%5Bnumber%5D=1",
        "last": "http://localhost:8000/api/v1/stories?page%5Bnumber%5D=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/v1/stories",
        "per_page": 15,
        "to": 2,
        "total": 2
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Single Story
This request show **a single exiting story,** it can be obtained using the **slug** of the stories. No authentication is needed.
### Method: GET
>```
>http://localhost:8000/api/v1/stories/story-1
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### 🔑 Authentication

No Auth


### Response: 200
```json
{
    "data": {
        "type": "stories",
        "id": "story-1",
        "attributes": {
            "title": "Story 1",
            "url": "story-1",
            "content": "9woPyLiXQ8"
        },
        "links": {
            "self": "http://localhost:8000/api/v1/stories/story-1"
        }
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Create Story
This request allows to **store** a single story in the database. **Only authenticated users** can perform this task.
### Method: POST
>```
>http://localhost:8000/api/v1/stories
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Headers

|Content-Type|Value|
|---|---|
|Content-Type|application/vnd.api+json|


### Body (**raw**)

```json
{
    "data": {
        "type": "stories",
        "attributes": {
            "title": "Murder Still Alive",
            "url": "murder-still-alive",
            "content": "9woPyLiXQ8"
        }
    }
}
```

### 🔑 Authentication bearer

|Param|value|Type|
|---|---|---|
|token|plain_text_token|string|


### Response: 201
```json
{
    "data": {
        "type": "stories",
        "id": "murder-still-alive",
        "attributes": {
            "title": "Murder Still Alive",
            "url": "murder-still-alive",
            "content": "9woPyLiXQ8"
        },
        "links": {
            "self": "http://localhost:8000/api/v1/stories/murder-still-alive"
        }
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Update Story
This request allows to **update** an exiting story in the database. **Only authenticated users** can perform this task.
### Method: PATCH
>```
>http://localhost:8000/api/v1/stories/story-1
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Headers

|Content-Type|Value|
|---|---|
|Content-Type|application/vnd.api+json|


### Body (**raw**)

```json
{
    "data": {
        "type": "stories",
        "id": "story-1",
        "attributes": {
            "title": "Story 1 UPDATED",
            "url": "story-1",
            "content": "Lorem Ipsum"
        }
    }
}
```

### 🔑 Authentication bearer

|Param|value|Type|
|---|---|---|
|token|plain_text_token|string|


### Response: 200
```json
{
    "data": {
        "type": "stories",
        "id": "story-1",
        "attributes": {
            "title": "Story 1 UPDATED",
            "url": "story-1",
            "content": "Lorem Ipsum"
        },
        "links": {
            "self": "http://localhost:8000/api/v1/stories/story-1"
        }
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Delete Story
This request allows to **delete** a single story in the database. **Only authenticated users** can perform this task.
### Method: DELETE
>```
>http://localhost:8000/api/v1/stories/story-1
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### 🔑 Authentication bearer

|Param|value|Type|
|---|---|---|
|token|plain_text_token|string|


### Response: 204
```json
null
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Filter Stories
We can filter stories by a given attribute. Based on JSON:API Spec, we need to use the `filter` keyword, followed by the attribute to be filter and finally the value of the filter like below:

> url/stories?**filter**\[**title**\]=**example title**

Note that the attribute must be enclosure in square brackets (`[]`).
### Method: GET
>```
>http://localhost:8000/api/v1/stories?filter[title]=Story 2
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Query Params

|Param|value|
|---|---|
|filter[title]|Story 2|


### Response: 200
```json
{
    "data": [
        {
            "type": "stories",
            "id": "story-2",
            "attributes": {
                "title": "Story 2",
                "url": "story-2",
                "content": "OZOb1w1yDz"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-2"
            }
        }
    ],
    "links": {
        "self": "http://localhost:8000/api/v1/stories",
        "first": "http://localhost:8000/api/v1/stories?filter%5Btitle%5D=Story%202&page%5Bnumber%5D=1",
        "last": "http://localhost:8000/api/v1/stories?filter%5Btitle%5D=Story%202&page%5Bnumber%5D=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/v1/stories",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Sort Stories
We can sort stories by a given attribute. Based on JSON:API Spec, we need to use the `sort` keyword, followed by the attribute to be sorted like below:

> url/stories?**sort**\=(-)**example_attribute**

Note that the attribute may prefixed within minus symbole (`-`) to sort resources descending, this is optional and resources is sorted ascending by default.
### Method: GET
>```
>http://localhost:8000/api/v1/stories?sort=-content
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Query Params

|Param|value|
|---|---|
|sort|-content|


### Response: 200
```json
{
    "data": [
        {
            "type": "stories",
            "id": "story-5",
            "attributes": {
                "title": "Story 5",
                "url": "story-5",
                "content": "zacJzrEtMr"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-5"
            }
        },
        {
            "type": "stories",
            "id": "story-2",
            "attributes": {
                "title": "Story 2",
                "url": "story-2",
                "content": "RffpaecHCg"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-2"
            }
        },
        {
            "type": "stories",
            "id": "story-4",
            "attributes": {
                "title": "Story 4",
                "url": "story-4",
                "content": "CT5WdfRve7"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-4"
            }
        },
        {
            "type": "stories",
            "id": "story-3",
            "attributes": {
                "title": "Story 3",
                "url": "story-3",
                "content": "9vU6yTd04i"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-3"
            }
        },
        {
            "type": "stories",
            "id": "story-1",
            "attributes": {
                "title": "Story 1",
                "url": "story-1",
                "content": "2fB133u1zc"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-1"
            }
        }
    ],
    "links": {
        "self": "http://localhost:8000/api/v1/stories",
        "first": "http://localhost:8000/api/v1/stories?sort=-content&page%5Bnumber%5D=1",
        "last": "http://localhost:8000/api/v1/stories?sort=-content&page%5Bnumber%5D=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/v1/stories",
        "per_page": 15,
        "to": 5,
        "total": 5
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Paginate Stories
Pagination is avaliable to stories. Based on JSON:API Spec, we need to use the `page` keyword, followed by the `size` keyword with the value of the page size, and finally the `page` keyword followed by the number keyword with the value of current page:

> url/stories?`page`\[`size`\]=`page_size_value`&`page`\[`number`\]=`current_page_number`"
### Method: GET
>```
>http://localhost:8000/api/v1/stories?page[size]=3&page[number]=2
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Query Params

|Param|value|
|---|---|
|page[size]|3|
|page[number]|2|


### Response: 200
```json
{
    "data": [
        {
            "type": "stories",
            "id": "story-4",
            "attributes": {
                "title": "Story 4",
                "url": "story-4",
                "content": "CT5WdfRve7"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-4"
            }
        },
        {
            "type": "stories",
            "id": "story-5",
            "attributes": {
                "title": "Story 5",
                "url": "story-5",
                "content": "zacJzrEtMr"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-5"
            }
        }
    ],
    "links": {
        "self": "http://localhost:8000/api/v1/stories",
        "first": "http://localhost:8000/api/v1/stories?page%5Bsize%5D=3&page%5Bnumber%5D=1",
        "last": "http://localhost:8000/api/v1/stories?page%5Bsize%5D=3&page%5Bnumber%5D=2",
        "prev": "http://localhost:8000/api/v1/stories?page%5Bsize%5D=3&page%5Bnumber%5D=1",
        "next": null
    },
    "meta": {
        "current_page": 2,
        "from": 4,
        "last_page": 2,
        "path": "http://localhost:8000/api/v1/stories",
        "per_page": "3",
        "to": 5,
        "total": 5
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: Paginate & Sort Stories
We may use pagination, sort and filter together by separe each other with ampersand symbole (`&`) like below:

> url/stories?sort=content`&`page\[size\]=3&page\[number\]=2
### Method: GET
>```
>http://localhost:8000/api/v1/stories?sort=content&page[size]=3&page[number]=2
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/vnd.api+json|


### Query Params

|Param|value|
|---|---|
|sort|content|
|page[size]|3|
|page[number]|2|


### Response: 200
```json
{
    "data": [
        {
            "type": "stories",
            "id": "story-2",
            "attributes": {
                "title": "Story 2",
                "url": "story-2",
                "content": "RffpaecHCg"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-2"
            }
        },
        {
            "type": "stories",
            "id": "story-5",
            "attributes": {
                "title": "Story 5",
                "url": "story-5",
                "content": "zacJzrEtMr"
            },
            "links": {
                "self": "http://localhost:8000/api/v1/stories/story-5"
            }
        }
    ],
    "links": {
        "self": "http://localhost:8000/api/v1/stories",
        "first": "http://localhost:8000/api/v1/stories?sort=content&page%5Bsize%5D=3&page%5Bnumber%5D=1",
        "last": "http://localhost:8000/api/v1/stories?sort=content&page%5Bsize%5D=3&page%5Bnumber%5D=2",
        "prev": "http://localhost:8000/api/v1/stories?sort=content&page%5Bsize%5D=3&page%5Bnumber%5D=1",
        "next": null
    },
    "meta": {
        "current_page": 2,
        "from": 4,
        "last_page": 2,
        "path": "http://localhost:8000/api/v1/stories",
        "per_page": "3",
        "to": 5,
        "total": 5
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃
_________________________________________________
Powered By: [postman-to-markdown](https://github.com/bautistaj/postman-to-markdown/)
