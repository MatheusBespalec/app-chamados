<?php

namespace App\Models\Interfaces;

interface Messageable
{
    /**
     * Get the notes of model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages();
}
