<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // app/Models/Role.php

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
