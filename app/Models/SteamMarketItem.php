<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamMarketItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon_large', 'icon', 'game', 'data'];
}
