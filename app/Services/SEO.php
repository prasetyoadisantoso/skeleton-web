<?php

namespace App\Services;

use App\Models\Meta;
use App\Models\Opengraph;

class SEO
{

    protected $meta, $opengraph;

    public function __construct(
        Meta $meta,
        Opengraph $opengraph,
    ) {
        $this->meta = $meta;
        $this->opengraph = $opengraph;
    }

    public function MetaHome()
    {
        return [
            'meta' => $this->meta->query()->where('name', 'Home')->get()
        ];
    }

    public function OpengraphHome() {;

        return [
            'opengraph' => $this->opengraph->query()->where('name', 'Home')->get()
        ];
    }

}
