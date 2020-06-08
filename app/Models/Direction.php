<?php


namespace App\Models;


class Direction extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'text',
        'direction_img',
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
