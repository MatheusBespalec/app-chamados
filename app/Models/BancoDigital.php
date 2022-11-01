<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancoDigital extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bancos_digitais';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'webhook',
        'env_lambda',
        'project_id',
        'customer_id',
    ];

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    /**
     * The customers that belong to the project.
     */
    public function bancoDigital()
    {
        return $this->hasOne(BancoDigital::class);
    }
}
