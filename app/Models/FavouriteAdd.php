<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteAdd extends Model
{
    use HasFactory;

    protected $table = 'favourite_add';

    protected $fillable = [
       'ads_id',
       'user_id',
    ];
}
