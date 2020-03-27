<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Feeds extends Model
{
    use Notifiable;
    //
    public function getLink()
    {
        $path = env('APP_URL') . '/' . $this->image;
        return $path;
    }
}
