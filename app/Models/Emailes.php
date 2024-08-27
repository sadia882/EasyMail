<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emailes extends Model
{
    protected $fillable = ['to', 'subject', 'body'];

    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class);
    }
}
