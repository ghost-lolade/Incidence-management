<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Eloquence;


class Category extends Model
{
    use Notifiable;
    //
    protected $table = 'categories';


    protected $searchableColumns = ['name'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $guarded = [];
}
