<?php
use Illuminate\Database\Query\Builder;

Builder::macro("match", function ($cols){
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
        $this->bindings['matches'][] = $col;
    }

    return $this;
});