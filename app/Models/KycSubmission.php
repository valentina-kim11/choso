<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'id_number',
        'front_image_path',
        'back_image_path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
