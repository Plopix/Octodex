# Plopix Octodex Provider

Provide a PHP class which allow you to retrieve easily links of OCTOCAT® png file.

## Usage

```php
$provider = new \Plopix\Octodex\Provider();
$cat = $provider->getRandom();
print $cat;
print $provider->getNumber(42);
```

## With Symfony as a Service ?

### Create a service

```yml
# Resources/config/services.yml
    Plopix\Octodex\Provider:
        arguments: ['%kernel.cache_dir%',43200]
```

## Special notes and other considerations

GITHUB® owns all of the OCTOCAT®, this code just retrieves the data.

GITHUB®, the GITHUB® logo design, OCTOCAT® and the OCTOCAT® logo design 
are exclusive trademarks registered in the United States by GitHub, Inc.
The OCTOCAT design is the exclusive property of GitHub, Inc and has been federally registered with the
United States Copyright Office. All rights reserved. No adaptation or use of any kind
of any of our registered trademarks or copyrights, or any other contents of this website,
is allowed without the express written permission of GitHub, Inc.

See more: [https://octodex.github.com/faq.html](https://octodex.github.com/faq.html)
