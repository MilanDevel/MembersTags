<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name',
        'description',
    ];

    public function member(): BelongsToMany{
        return $this->belongsToMany(Member::class, 'members_tags');
    }
}
