<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'position',
        'department_id',
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
        
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
        
    }
    public function departments()
    {
        return $this->belongsTo(Department::class);
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class);
}


}
