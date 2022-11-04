<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_lasers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_serial_no',
        'laser_cutting',
        'cnc',
        'torna',
        'assembling',
        'electric_and_automation',
        'total',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'laser_cutting' => 'double',
        'cnc' => 'double',
        'torna' => 'double',
        'assembling' => 'double',
        'electric_and_automation' => 'double',
        'total' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
}
