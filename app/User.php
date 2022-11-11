<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Uuids;
use Spatie\Permission\Traits\HasRoles;
use \Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes, HasApiTokens;

    Protected $guard_name ='api';


    protected $revisionCreationsEnabled = true;


    const admin = 'admin';
    const padrao = 'default';
    const gerente = 'gerente';
    const SUPERVISOR = 'supervisor';
    const CONSULTOR = 'consultor';

    const STATUS_LISTA = [
        self::admin  => 'Administrador',
        self::padrao  => 'Usuário Padrão',
        self::gerente  => 'Secretário',
        self::SUPERVISOR  => 'Supervisor',
        self::CONSULTOR  => 'Consultor',

    ];
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) \Str::orderedUuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }


    public function getTipoUsuario()
    {
        return self::STATUS_LISTA[$this->tipo];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tipo', 'photo', 'tenant_id','cpf'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','tenant_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
