<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'birthdate',
        'phone',
    ];

    protected function casts()
    {
        return [
            'birthdate' => 'date',
        ];
    }

    public function tag(): BelongsToMany{
        return $this->belongsToMany(Tag::class, 'members_tags');
    }
}
