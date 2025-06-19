<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerjaSama extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partnerships';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organisation_id',
        'partnership_type',
        'title',
        'details',
        'document',
        'start_date',
        'end_date',
        'approval_date',
        'status',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approval_date' => 'date',
    ];

    /**
     * Get the organisation that owns the partnership.
     */
    public function organisation()
    {
        return $this->belongsTo(Organisasi::class, 'organisation_id');
    }
}
