<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'adresse', 'latlng'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function activityReports()
    {
        return $this->hasMany(ActivityReport::class);
    }
}

