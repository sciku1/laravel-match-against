<?php

use Illuminate\Database\Query\Builder;

Builder::macro("against", function ($search, $booleanMode = false) {
    if (!empty($this->bindings['against'])) {
        $this->bindings['against'] = null;
    }

    if (empty($this->bindings['matches'])) {
        $this->bindings['matches'] = [];
    }

    foreach ($this->bindings['matches'] as $match => $matched) {
        $components = explode('.', $match);
        if (count($components) > 1) {
            $as = $components[0] . "_" . $components[1] . "_score";
        } else {
            $as = $this->from . "_" . $match;
        }

        if (!$matched) {
            $this->selectRaw("MATCH ($match) AGAINST (?) AS $as", [$search]);

            $this->bindings[$match] = true;
        }
    }

    return $this;
});