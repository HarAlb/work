<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpRelationship extends Model
{

    protected $table = 'ip_relationships';
    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id' , 'website_id'
    ];

    public function websites(){
        return $this->hasMany( 'App\Website' , 'id' , 'website_id');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
