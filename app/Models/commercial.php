<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commercial extends Model
{
    use HasFactory;
    protected $table = 'commercials';

    protected $guarded = [];

    public function GetAllAffilited() {
      return $this->hasMany(Marchand::class);
    }
}
