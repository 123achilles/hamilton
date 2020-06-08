<?php


namespace App\Models;


class Choice extends BaseModel
{

    /**
     * @var array
     */
    protected $fillable = [
        'question_id',
        'title',
        'choice_img',
        'is_correct',
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
