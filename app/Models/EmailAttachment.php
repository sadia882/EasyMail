<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    protected $fillable = ['emailes_id', 'filename', 'path'];

    public function email()
    {
        return $this->belongsTo(Emailes::class);
    }
}
