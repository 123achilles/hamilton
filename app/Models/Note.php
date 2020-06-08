<?php


namespace App\Models;


class Note extends BaseModel
{

    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'note',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
