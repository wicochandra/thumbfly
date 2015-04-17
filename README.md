# ThumbFly
Simple image processing web service for thumbnail. This service utilize [Intervention Image](http://image.intervention.io/) to process the image. This web service need help of proxy server such as nginx.

## Feature
* Resize
* Crop
* Fit (Resize and crop combination)
* Heighten
* Widen
* Greyscale

## Usage
Here is example usage of this web service
```
http://path/to/image?greyscale&fit=300:500
http://path/to/image?format=jpg&quality=60
```

## Installation For Nginx
* Clone this repostiory,
* Run `composer install`
* Add server configuration for this web service (eq `listen localhost:9000`)
* (Cache) To enable cache you must add the following code insite `http` context. [Read this for more detail](https://serversforhackers.com/nginx-caching/)
```
proxy_cache_path /tmp/nginx levels=1:2 keys_zone=my_zone:10m inactive=60m;
proxy_cache_key "$scheme$request_method$host$request_uri";

```
* On your website nginx configuration add the following code inside `server` context.
```
location ~ \.(jpg|png)$ {
    # Uncomment these if you want enable cache
    # proxy_cache my_zone;
    # proxy_cache_valid 200 60m;
    # proxy_cache_valid 404  1m;

    include proxy_params;
    proxy_set_header X-REALPATH $realpath_root$uri;
    proxy_pass http://127.0.0.1:9000; # Make sure same as the web service listen
}
* Reload nginx service
```

## References

* `resize=width:height`
* `crop=width:height[:x[:y]]`
* `fit=width:height[:position]` [Read detail](http://image.intervention.io/api/fit)
* `heighten=height`
* `widen=width`
* `grayscale`
* `format=[jpg|png|gif]`
* `quality=[1-100]`
