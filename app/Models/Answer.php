<?php


namespace App\Models;


class Answer extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'choice_id',
        'answer',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
