<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    public function category(){

     return $this->belongsTo('App\Category');//only one model
    }

    public function user(){

        return $this->belongsTo('App\User');//only one model
       }

   public function comments(){
       return $this->hasMany('App\Comment');// model collection(model of array)
   }
}
