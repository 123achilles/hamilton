<?php


namespace App\Models;


class Question extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'passage_id',
        'question',
        'question_img',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function passage()
    {
        return $this->belongsTo(Passage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
