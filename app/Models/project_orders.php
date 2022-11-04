<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\purchases;
use App\Models\project_motors;
use App\Models\project_metals;
use App\Models\project_others;

class project_orders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchases_serial_no',
        'project_serial_no',
        'item_id',
        'item',
        'Code',
        'details',
        'delivery',
        'price',
        'qty',
        'total',
        'photo',
        'description',
        'status',
        'canceled',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'canceled' => 'integer',
        'status' => 'integer',
        'price' => 'double',
        'total' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function Projects(){
        $this->belongsTo(Project::class,'project_orders.project_serial_no','projects.serial_no')->orderBy('created_at', 'DESC');
    }

    function purchases(){
        $this->belongsTo(purchases::class,'project_orders.purchases_serial_no','purchases.serial_no')->orderBy('created_at', 'DESC');
    }

    function motors(){
        return $this->hasMany(project_motors::class,'item_id','id');
    }

    function metals(){
        return $this->hasMany(project_metals::class,'item_id','id');
    }

    function others(){
        return $this->hasMany(project_others::class,'item_id','id');
    }
}
