<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourObjectAttributes extends Model
{
    use UsedByTeams;

    protected $table = 'tour_object_attributes';

    protected $fillable = ['name', 'description', 'qnt', 'price', 'extra', 'customer_type_id'];

    protected $casts = [
        'price' => 'float',
        'extra' => 'array'
    ];

    public function objectable()
    {
        return $this->morphTo();
    }
}
