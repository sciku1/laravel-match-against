<?php

namespace Sciku1\LaravelMatchAgainst\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;

class MatchAgainstServiceProvider extends ServiceProvider
{
    private $matchGrammar = [
        "mysql" => "MATCH",
        "pgsql" => "",
        "sqlite" => "",
        "sqlsrv" => "",
    ];

    private $againstGrammar = [
        "mysql" => "AGAINST",
        "pgsql" => "",
        "sqlite" => "",
        "sqlsrv" => "",
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $match = $this->matchGrammar[$driver];
        $against = $this->againstGrammar[$driver];


        Builder::macro("match", function ($cols) use ($match) {
            if (!empty($this->bindings['against'])) {
                $this->bindings['against'] = null;
            }

            if (empty($this->bindings['matches'])) {
                $this->bindings['matches'] = [];
            }

            if (!is_array($cols)) {
                $cols = [$cols];
            }

            foreach ($cols as $col) {
                $this->bindings['matches'][$col] = false;
            }


            return $this;
        });

        Builder::macro("against", function ($search, $booleanMode = false) use ($against) {
            if (!empty($this->bindings['against'])) {
                $this->bindings['against'] = null;
            }

            if (empty($this->bindings['matches'])) {
                $this->bindings['matches'] = [];
            }

            foreach ($this->bindings['matches'] as $match => $matched) {
                $components = explode('.', $match);
                $as = $components[0] . "_" . $components[1] . "_score";
                if (!$matched) {
                    $this->selectRaw("MATCH ($match) AGAINST (?) AS $as", [$search])
                        ->orderBy($as, 'DESC');

                    $this->bindings[$match] = true;
                }
            }

            return $this;
        });

        Blueprint::macro("fulltext", function ($name) {

        });
    }
}
