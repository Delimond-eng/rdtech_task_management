<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityReport extends Model
{
    use HasFactory;

    protected $fillable = ['agent_id', 'activity_id', 'site_id', 'date', 'commentaire', 'latlng', 'status'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function taches()
    {
        return $this->belongsToMany(Tache::class, 'activity_report_taches', 'report_id', 'tache_id')
                    ->withTimestamps();
    }
}

