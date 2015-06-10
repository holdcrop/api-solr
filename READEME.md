

## Notes:
* https://github.com/solariumphp/solarium/pull/328/files
** Applied this fix to the Solarium Core in order to use Solr Version 5.1
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