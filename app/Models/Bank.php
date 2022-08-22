<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    /**
     * Get the parent bankable model (enterprise or other enterprise).
     */
    public function bankable()
    {
        return $this->morphTo();
    }
}
