<?php


namespace App\Models;


class Exam extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function sections()
    {
        return $this->hasMany(Section::class);
    }
}
