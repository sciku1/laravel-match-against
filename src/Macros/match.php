<?php
use Illuminate\Database\Query\Builder;

Builder::macro("match", function ($cols){

    if (empty($this->matches)) {
        $this->matches = [];
    }

    if (!is_array($cols)) {
        $cols = [$cols];
    }

    foreach ($cols as $col) {
        $this->matches[] = $col;
    }

    return $this;
});