<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'matricule','password', 'email', 'phone', 'status'];

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    public function activityReports()
    {
        return $this->hasMany(ActivityReport::class);
    }
}
