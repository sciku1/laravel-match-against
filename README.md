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
        Sciku1/LaravelMatchAgainst/Providers/MatchAgainstServiceProvider::class
	]
```

## Usage

To run match against queries, the field must have a fulltext index, currently there only way to do this is 

```
DB::statement('ALTER TABLE `table_name` ADD FULLTEXT index_name(col1, col2)');
```

Now you can run your query! 

```
Model::match(['col1', 'col2'])->against('search terms')->get();
```

You can also order by the aggregate of the scores, although right now it must be the last term.

```
Model::match(['col1', 'col2'])->against('search terms')->totalScore('DESC')->get() // or 'ASC'
```
