<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_motors extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_serial_no',
        'motor',
        'power',
        'title',
        'price',
        'qty',
        'unit',
        'total',
        'photo',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Power' => 'double',
        'price' => 'double',
        'total' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function project_orders()
    {
        return $this->belongsTo(project_orders::class);
    }
}
