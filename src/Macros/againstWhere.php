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

    foreach ($this->matches as $match) {

        $this->search = $search;
        $query = "MATCH ($match) AGAINST (? {$modeSql})";
        $this->orWhereRaw($query, [$search]);

    }

    return $this;
});