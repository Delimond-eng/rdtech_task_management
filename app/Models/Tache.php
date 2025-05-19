<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'description', 'activite_id', 'agent_id', 'status'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function activite()
    {
        return $this->belongsTo(Activity::class, 'activite_id');
    }

    public function activityReports()
    {
        return $this->belongsToMany(ActivityReport::class, 'activity_report_taches', 'tache_id', 'report_id')
                    ->withTimestamps();
    }
}

