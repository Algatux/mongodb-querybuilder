# mongodb-querybuilder
A query builder for mongodb

[![Build Status](https://travis-ci.org/Algatux/mongodb-querybuilder.svg?branch=master)](https://travis-ci.org/Algatux/mongodb-querybuilder)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Algatux/mongodb-querybuilder/?branch=master)

## Installation

require this library through composer:

```bash
composer require algatux/mongodb-querybuilder dev-master
```

##Usage example

```php
$builder = new Builder($mongodbCollection);

/** \MongoDB\Driver\Cursor */
$cursor = $builder
    ->select('_id', 'field1') // projection
    ->and(
        $builder->expr()->or( // $or
            ['field1' => 'value1'],
            ['field2' => 'value2'],
        ),
        ['field3' => 'value3']
    ) // $and
    ->sort(['field1' => -1]) // sort option
    ->limit(10) // limit option
    ->skip(2) // skip option
    ->setQueryOption('foo', $bar) // adds not actually method supported options
    ->find() // will trigger $collection->find() method
    ->getQuery()
    ->execute();
```