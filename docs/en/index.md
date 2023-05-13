Documentation
=============

More info you can see in:

- [Doc HTTPlug](http://docs.php-http.org/en/latest/httplug/introduction.html)
- [Doc HTTPlug Bundle](http://docs.php-http.org/en/latest/integrations/symfony-bundle.html) this extension is inspired by Httplug Bundle


Usage
-----

```php
    $requestFactory = $container->getService('httplug.requestFactory');
    $client = $container->getService('httplug.client.test');

    $request = $requestFactory->createRequest('GET', 'https://google.com');
    $response = $client->sendRequest($request);    
```


Example: add own custom plugin
------------------------------

```yaml
httplug:
    clients:
        test:
            factory: @httplug.factory.guzzle6
            plugins:
                customPlugin:
                    class: App\MyCustomPlugin # required
                    arguments: # optional (can use autowiring)
                        - %config%
                        - @service1
```


Full configuration
------------------

```yaml
extensions:
    httplug: FreezyBee\Httplug\DI\HttplugExtension

httplug:
    tracy:
        debugger: false # default true (by %debugMode%)
        plugins: [] # list of debug plugins
    clientDefaults:
        factory: @httplug.factory.guzzle6 # default factory for all clients
    clients:
        test:
            factory: @httplug.factory.guzzle6 # optional if you set clientDefaults.factory
            config:
                # Options to the Guzzle 6 constructor
                verify: false
                timeout: 2
            plugins:
                authentication:
                    type: 'basic'
                    username: 'my_username'
                    password: 'p4ssw0rd'
                authentication:
                    type: 'wsse'
                    username: 'my_username'
                    password: 'p4ssw0rd'
                authentication:
                    type: 'bearer'
                    token: 'authentication_token_hash'
                authentication:
                    type: 'service'
                    service: @my_authentication_service
                cache:
                    pool: @cachePsr6 # optional - can use autowire PSR6 cache pool
                    streamFactory: @streamFactory # required
                    config:
                        defaultTtl: 1
                        respectCacheHeaders: true
                cookie:
                    cookieJar: null # optional - if null, new http cookieJar is used
                decoder:
                    useContentEncoding: true # DON'T USE WITH CACHE!!!
                logger:
                    logger: @loggerPsr3 # optional - can use autowired PSR3
                    formatter: null
                redirect:
                    preserveHeader: true
                    useDefaultForMultiple: true
                retry:
                    retries: 1
                # Set host name including protocol and optionally the port number, e.g. https://api.local:8000
                addHost:
                    host: https://test.cz:443 # required
                    replace: false # Whether to replace the host if request already specifies it
                # Append headers to the request. If the header already exists the value will be appended to the current value.
                headerAppend:
                    headers:
                        'X-FOO': bar
                # Set header to default value if it does not exist.
                headerDefaults:
                    headers:
                        'X-FOO': bar
                # Set headers to requests. If the header does not exist it wil be set, if the header already exists it will be replaced.
                headerSet:
                    headers:
                        'X-FOO': bar
                # Remove headers from requests.
                headerRemove:
                    headers: ["X-FOO"]

        test2:
            factory: @httplug.factory.curl

        test3:
            factory: @httplug.factory.guzzle7

        test4:

```