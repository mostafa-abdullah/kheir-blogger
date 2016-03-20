<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    /**
     * get user who created this review
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * event review relation
     * @return mixed
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
