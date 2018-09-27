# Laravel Match Against

A simple macro for doing match against fulltext searches with the Eloquent ORM api, currently in beta. 

## Requirements
 - Laravel 5.x 
 - MySQL 3.3+

`composer require sciku1/laravel-match-against` 

## Laravel 5.5 
You're done!

## Laravel 5.x
You must register the service provider in your `config/app.php` 

```
'providers' => [
    ...
    Sciku1\LaravelMatchAgainst\Providers\MatchAgainstServiceProvider::class,
]
```

## Usage

To run match against queries, the field must have a fulltext index, currently there only way to do this is 

```
DB::statement('ALTER TABLE `table_name` ADD FULLTEXT index_name(col1, col2)');
```

### Order
The default behaviour is to order. Example:

```
Model::match(['col1', 'col2'])->against('search terms')->get();
```

will generate

```
SELECT * FROM models ORDER BY (MATCH (col1) AGAINST ('search terms')) DESC, (MATCH (col2) AGAINST ('search terms')) DESC
```

### Where 

To limit the results, you must use `whereAgainst()`

```
Model::match(['col1', 'col2'])->whereAgainst('search terms')->get();
```

will generate

```
SELECT * FROM models WHERE (MATCH (col1) AGAINST ('search terms')) > 0, (MATCH (col2) AGAINST ('search terms')) > 0
```

### TotalScore (deprecated)
You can get the sum of all results using totalScore(), but this will be removed in a later release.

