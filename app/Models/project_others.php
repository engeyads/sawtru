<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_others extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_serial_no',
        'title',
        'info',
        'details',
        'price',
        'qty',
        'total',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'double',
        'total' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function projects()
    {
        $this->belongsTo(Project::class);
    }

    public function project_orders()
    {
        $this->belongsTo(project_orders::class);
    }
}
