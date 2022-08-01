<?php

namespace App\Models\Interfaces;

interface Logable
{
    /**
     * Get the notes of model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function logs();
}
