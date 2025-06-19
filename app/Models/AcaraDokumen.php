<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcaraDokumen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'document_name',
        'file',
        'description',
    ];

    /**
     * Get the event associated with the document.
     */
    public function _event()
    {
        return $this->belongsTo(Acara::class, 'event_id');
    }
}
