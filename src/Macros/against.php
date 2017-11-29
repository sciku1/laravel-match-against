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
        $as = $components[0] . "_" . $components[1] . "_score";
        if (!$matched) {
            $this->selectRaw("MATCH ($match) AGAINST (?) AS $as", [$search])
                ->orderBy($as, 'DESC');

            $this->bindings[$match] = true;
        }
    }

    return $this;
});