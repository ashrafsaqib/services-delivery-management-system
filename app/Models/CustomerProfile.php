<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;
    
    protected $fillable = ['gender','user_id','buildingName','area','landmark','flatVilla','street','city','number','whatsapp'];

}
