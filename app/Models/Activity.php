<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'date', 'site_id'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'activite_id');
    }

    public function reports()
    {
        return $this->hasMany(ActivityReport::class, 'activity_id');
    }
}
