<?php


namespace App\Models;


class Section extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'title',
        'note',
        'time',
        'info',
        'reference_img',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passages()
    {
        return $this->hasMany(Passage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directions()
    {
        return $this->hasMany(Direction::class);
    }

}
