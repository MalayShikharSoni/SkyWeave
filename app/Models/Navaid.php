<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navaid extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'name',
        'type',
        'frequency',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'frequency' => 'decimal:2',
    ];

    /**
     * Valid NAVAID types.
     */
    public const TYPES = [
        'VOR',
        'DME',
        'VOR_DME',
        'NDB',
        'TACAN',
    ];
}
