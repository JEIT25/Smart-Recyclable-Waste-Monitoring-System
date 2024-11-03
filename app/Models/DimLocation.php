<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimLocation extends Model
{
    use HasFactory;

    protected $table = 'dim_location';

    protected $fillable = [
        'city',
        'barangay',
        'purok',
    ];

    // Define relationship with FactWasteCollection
    public function factWasteCollections()
    {
        return $this->hasMany(FactWasteCollection::class);
    }
}
