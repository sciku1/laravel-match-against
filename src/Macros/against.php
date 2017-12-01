<?php

use Illuminate\Database\Query\Builder;

Builder::macro("against", function ($search, $booleanMode = false) {
    if (empty($this->matches)) {
        $this->matches = [];
    }


    foreach ($this->matches as $match) {
        $components = explode('.', $match);
        if (count($components) > 1) {
            $as = $components[0] . "_" . $components[1] . "_score";
        } else {
            $as = $this->from . "_" . $match;
        }

        $boolSql = "";

        if ($booleanMode) {
            $boolSql = "IN BOOLEAN MODE";
        }

        $this->search = $search;
        $this->selectRaw("MATCH ($match) AGAINST (? {$boolSql}) AS $as", [$search]);

    }

    return $this;
});