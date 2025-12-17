<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ticket extends Model
{
    protected $fillable = [
        'title','category','priority','description','status',
        'author_id','assignee_id','due_date',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}