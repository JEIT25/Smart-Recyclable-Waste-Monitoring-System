<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactWasteCollection extends Model
{
    use HasFactory;

    // Disable timestamps for this model
    public $timestamps = false;

    protected $table = 'fact_waste_collections';

    protected $fillable = [
        'user_id',
        'dim_location_id',
        'dim_waste_id',
        'amount_collected',
        'collection_date',
    ];

    // Define relationships with other models
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function DimLocation()
    {
        return $this->belongsTo(DimLocation::class, 'dim_location_id');
    }

    public function dimWaste()
    {
        return $this->belongsTo(DimWaste::class, 'dim_waste_id');
    }
}
