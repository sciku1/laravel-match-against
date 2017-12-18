<?php

use Illuminate\Database\Query\Builder;

Builder::macro("againstWhere", function ($search, $mode = '') {
    if (empty($this->matches)) {
        $this->matches = [];
    }

    switch ($mode) {
        case 'boolean':
            $modeSql = 'IN BOOLEAN MODE';
            break;
        case 'natural':
            $modeSql = 'IN NATURAL LANGUAGE MODE';
            break;
        default:
            $modeSql = '';
            break;
    }

    $matches = $this->matches;
    $this->search = $search;
    $this->where(function ($q) use ($matches, $search, $modeSql) {
        foreach ($this->matches as $match) {
            $querySql = "MATCH ($match) AGAINST (? {$modeSql}) > 0";
            $q->orWhereRaw($querySql, [$search]);
        }
    });


    return $this;
});