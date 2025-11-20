<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    protected $table = 'students' ;


    protected $primarykey = 'id';


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'

    ];

    public function profile () {


        return $this->hasOne(Profile::class);
    }


    public function course () {


        return $this->belongsToMany(Course::class);
    }
}
