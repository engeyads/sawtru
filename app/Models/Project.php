<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\project_orders;
use App\Models\purchases;
use App\Models\Comments;
use App\Models\project_metals;
use App\Models\project_motors;
use App\Models\project_others;
use App\Models\project_lasers;
use App\Models\project_assembling_photos;
use App\Models\project_diagram_photos;
use App\Models\project_horizontal_photos;
use App\Models\project_vertical_photos;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial_no',
        'uid',
        'admin',
        'pname',
        'photo',
        'length',
        'width',
        'height',
        'unit',
        'volume',
        'cubic_unit',
        'machine_voltage',
        'type',
        'details',
        'totlal',
        'due_time',
        'isApproved',
        'phase',
        'phases_times',
        'daysneed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'length' => 'double',
        'width' => 'double',
        'height' => 'double',
        'volume' => 'double',
        'machine_voltage' => 'int',
        'type' => 'int',
        'totlal' => 'double',
        'drawing_time' => 'date',
        'phases_times' => 'array',
        'approved_date' => 'datetime',
    ];


    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function phases_times(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }


    function user(){
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function project_orders()
    {
        return $this->hasMany(project_orders::class);
    }

    public function purchases()
    {
        return $this->hasMany(purchases::class);
    }

    function comments(){
        return $this->hasMany(Comments::class,'project_serial_no','serial_no')->orderBy('created_at', 'DESC');
    }

    function metals(){
        return $this->hasMany(project_metals::class,'project_serial_no','serial_no');
    }

    function motors(){
        return $this->hasMany(project_motors::class,'project_serial_no','serial_no');
    }

    function others(){
        return $this->hasMany(project_others::class,'project_serial_no','serial_no');
    }

    function lasers(){
        return $this->hasOne(project_lasers::class,'project_serial_no','serial_no');
    }

    function assemblingphts(){
        return $this->hasMany(project_assembling_photos::class,'project_serial_no','serial_no');
    }

    function diagramphts(){
        return $this->hasMany(project_diagram_photos::class,'project_serial_no','serial_no');
    }

    function horizontalphts(){
        return $this->hasMany(project_horizontal_photos::class,'project_serial_no','serial_no');
    }

    function verticalphts(){
        return $this->hasMany(project_vertical_photos::class,'project_serial_no','serial_no');
    }


}
