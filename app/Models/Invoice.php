<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    /**
     * @return BelongsTo
     */
    public function consigner(): BelongsTo
    {
        return $this->belongsTo(OtherEnterprise::class);
    }

    /**
     * @return BelongsTo
     */
    public function consignee(): BelongsTo
    {
        return $this->belongsTo(OtherEnterprise::class);
    }

    /**
     * @return BelongsTo
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(OtherEnterprise::class);
    }
}
