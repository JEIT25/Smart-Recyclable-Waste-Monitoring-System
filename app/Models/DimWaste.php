<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimWaste extends Model
{
    use HasFactory;
    // Disable timestamps for this model
    public $timestamps = false;

    protected $table = 'dim_wastes';

    protected $fillable = [
        'waste_name',
        'category_name',
        'est_weight'
    ];

    // Define relationship with FactWasteCollection
    public function factWasteCollections()
    {
        return $this->hasMany(FactWasteCollection::class);
    }
}
