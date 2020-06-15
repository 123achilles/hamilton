<?php


namespace App\Models;


class Passage extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'section_id',
        'title',
        'passage',
        'img_url',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
