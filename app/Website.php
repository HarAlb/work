<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token' , 'website_title' , 'website_url' , 'website_full_url'
    ];


    public function relations(){
        return $this->hasMany('App\IpRelationship');
    }
}
