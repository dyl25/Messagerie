<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
      'content', 'from_id', 'to_id', 'read_at', 'created_at'
    ];
    
    //we don't use the default field generate by default
    public $timestamps = false;
    
    //we specify our personnal timestamps field
    protected $dates = ['read_at', 'created_at'];
}
