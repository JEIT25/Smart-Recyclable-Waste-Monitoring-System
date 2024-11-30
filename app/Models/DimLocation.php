<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimLocation extends Model
{
    // Disable timestamps for this model
    public $timestamps = false;
    use HasFactory;

    protected $table = 'dim_locations';

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
