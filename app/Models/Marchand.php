<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marchand extends Model
{
    use HasFactory;

    protected $table = 'marchands';

    protected $guarded = [];

    public $timestamps = false;

    public function GetCommercial() {
      return $this->belongsTo(commercial::class, 'commercial_id');
    }

}
