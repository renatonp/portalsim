<?php

namespace App;

// use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\MakePassword as MakePasswordNotification;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use  Notifiable;
    // use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'cpf', 
        'celphone', 
        'phone', 
        'birthdate', 
        'sex',
        'voterstitle',
        'dt_expedicao',
        'orgao_emissor',
        'mothersname',
        'cep',
        'uf',
        'city',
        'district',
        'address',
        'number',
        'complement',
        'nome_responsavel',
        'nome_razao_social',
        'inscricao_estadual',

        'numcgm',
        'colaborador',
        
        'profissoes',
        'pis_pasep_ci',
        'renda',
        'local_trabalho',
        'telefone_comercial',
        'celular_comercial',
        'email_comercial',
        'cep_comercial',
        'endereco_comercial',
        'complemento_comercial',
        'bairro_comercial',
        'municipio_comercial',
        'estado_comercial',
        'email_verified_at',
        
        'fornecedor',
        'contato',
        'contato_cpf',
        'contato_celular',
        'contato_email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));

        // Não esquece: use App\Notifications\ResetPassword;
        // $this->notify(new ResetPassword($token));
    }
    
    /**
     * Retorna o nome reduzido do usuário (primeiro e último nome)
     * @return string
     */
    public function shortName() 
    {
        $name = explode(' ', $this->name);
        
        $firstName = $name[0];
        $lastName = $name[count($name) - 1];
        
        return "{$firstName} {$lastName}";
    }

    public function sendPasswordMakeNotification($token)
    {
        // Não esquece: use App\Notifications\MakePassword;
        $this->notify(new MakePasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail); // my notification
    }
}