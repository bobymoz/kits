<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use GlobalStatus;

    protected $casts = [
        'information' => 'object',
        'seo_content'=>'object',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeWithActiveCategories($query)
    {
        return $query->active()
            ->whereHas('category', function ($query) {
                $query->active();
            })
            ->whereHas('subcategory', function ($query) {
                $query->active();
            });
    }

    public function typeBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->type == Status::PRODUCT_FREE) {
                $html = '<span class="badge badge--warning">' . trans('Free') . '</span>';
            } else {
                $html = '<span class="badge badge--primary">' . trans('Paid') . '</span>';
            }
            return $html;
        });
    }
}
