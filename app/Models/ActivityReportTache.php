<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ActivityReportTache extends Pivot
{
    protected $table = 'activity_report_taches';

    protected $fillable = [
        'tache_id',
        'report_id',
        'commentaire',
        'status',
    ];

    public $timestamps = true;
}