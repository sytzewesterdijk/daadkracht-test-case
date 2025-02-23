<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inquiry extends Model
{
    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
