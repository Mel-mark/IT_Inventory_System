<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class his_tokens extends Model
{
    use HasFactory;
    protected $fillable = [
       'personel_id',	'item_id',	'remarks'	
    ];
}
