# mongodb-querybuilder
A query builder for mongodb

[![Build Status](https://travis-ci.org/Algatux/mongodb-querybuilder.svg?branch=master)](https://travis-ci.org/Algatux/mongodb-querybuilder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/?branch=master)

## Installation

require this library through composer:

```bash
composer require algatux/mongodb-querybuilder
```

##Usage example

```php
$builder = new Builder($mongodbCollection);

/** \MongoDB\Driver\Cursor */
$cursor = $builder
    ->select('_id', 'field1')
    ->and(
        $builder->expr()->or(
            ['field1' => 'value1'],
            ['field2' => 'value2'],
        ),
        ['field3' => 'value3']
    )
    ->sort(['field1' => -1])
    ->setMaxResults(10)
    ->find()
    ->getQuery()
    ->execute();
```