<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimWaste extends Model
{
    use HasFactory;

    protected $table = 'dim_waste';

    protected $fillable = [
        'waste_name',
        'category_name',,
        'est_weight'
    ];

    // Define relationship with FactWasteCollection
    public function factWasteCollections()
    {
        return $this->hasMany(FactWasteCollection::class);
    }
}
