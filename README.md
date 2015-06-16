# RESTful API with Solr
This project uses a RESTful API to accept JSON POSTs and store them in a Solr Core.

## Requirements
* Solr version 5.1

## Installation
* Clone the repository and run a _composer update_
* Add appropriate write permissions to the __storage/rate_limits__ directory in order for the _RateLimiter_ middleware to run.
Otherwise, remove the _RateLimiter_ instance from the list of middleware to be run in _App.php_. An _Internal Server Error (500)_ will be thrown otherwise when you try to access the application.
* The _document root_ for your HTTP Server is __public__. A _.htaccess_ is included already for use with _Apache HTTP Server_.

## Notes:
* https://github.com/solariumphp/solarium/pull/328/files
* Applied this fix to the Solarium Core in order to use Solr Version 5.1
```php
    if (!isset($options['headers']['Content-Type'])) {
        if($request->getHandler() == 'update') {
            $options['headers']['Content-Type'] = 'text/xml; charset=utf-8';
        }
        else {
            $options['headers']['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
        }
    }
```
