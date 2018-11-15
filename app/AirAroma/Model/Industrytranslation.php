<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Industrytranslation extends Model
{
    protected $primaryKey = 'idt_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     *
     */
    protected $fillable = ['idt_ind_id', 'idt_web_id', 'idt_name', 'idt_slug'];
}
