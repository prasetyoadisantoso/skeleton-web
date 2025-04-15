<?php

namespace App\Services;

class GlobalView
{
    public function RenderView($data)
    {
        foreach ($data as $value) {
            view()->share($value);
        }
    }
}
