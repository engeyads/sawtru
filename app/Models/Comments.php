<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_serial_no',
        'byid',
        'toid',
        'content',
        'created_at',
        'updated_at',
        'isRead',
        'available',
        'removed_at',
        'removed_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    function user(){
        return $this->belongsTo('App\Models\User','byid','id');
    }

    public function projects()
    {
        $this->hasMany(Project::class);
    }

    public function purchases()
    {
        $this->hasMany(purchases::class);
    }
}
