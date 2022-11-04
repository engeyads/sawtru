<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchases extends Model
{
    use HasFactory;

    protected $table = 'purchases';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',
        'project_serial_no',
        'price',
        'status',
        'items',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'items' => 'integer',
        'status' => 'integer',
        'price' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function Projects(){
        return $this->belongsTo(Project::class,'project_serial_no','serial_no')->orderBy('created_at', 'DESC');
    }

    function project_orders()
    {
        return $this->hasMany(project_orders::class,'purchases_serial_no','serial_no')->orderBy('created_at', 'DESC');
    }

    function comments(){
        return $this->hasMany(Comments::class,'purchases_serial_no','serial_no')->orderBy('created_at', 'DESC');
    }
}
