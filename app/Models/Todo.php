<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Todo extends Model
{
    use HasFactory;
    protected $table = 'todos';
    protected $fillable = [
        "title",
        "description",
        "done",
        "done_at"
    ];
    
    public function done()
    {
        $this->update([
            "done" => true,
            "done_at" => Carbon::now()
        ]);
    }

    public function undone(){
        $this->update([
            'done' => false,
            'done_at' => null
        ]);
    }
}