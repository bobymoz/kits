<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileFormat extends Model
{
    protected $guarded = ['id'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }
}
