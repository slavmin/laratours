<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;

class TourObjectAttributes extends Model
{
    protected $table = 'tour_object_attributes';

    protected $fillable = ['name', 'description', 'qnt', 'price', 'extra'];

    protected $casts = [
        'price' => 'float',
        'extra' => 'array'
    ];

    public function objectable()
    {
        return $this->morphTo();
    }
}
