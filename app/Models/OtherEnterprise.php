<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherEnterprise extends Model
{
    use HasFactory;

    /**
     * Get all the other enterprise's phones.
     */
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Get all the other enterprise's banks.
     */
    public function banks()
    {
        return $this->morphMany(Bank::class, 'bankable');
    }
}
