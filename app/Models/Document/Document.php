<?php

namespace App\Models\Document;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes, UsedByTeams;

    protected $fillable = [
        'name',
        'description',
        'template',
        'pdf_for_agent',
        'word_for_agent',
        'pdf_for_tourist',
        'word_for_tourist',
        'operator_id',
    ];
}
