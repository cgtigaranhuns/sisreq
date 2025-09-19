<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Configuracoe extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'id',
        'nome_instituicao',
       'endereco_instituicao',
        'contato_instituicao',
        'versao_sistema',
        'data_atualizacao',
        'logo_instituicao',
        'versao_db',
        'data_atualizacao_db',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'mail_admin',
        'ldap_adm_hostname',
        'ldap_adm_username',
        'ldap_adm_password',
        'ldap_adm_base_dn',
        'ldap_labs_hostname',
        'ldap_labs_username',
        'ldap_labs_password',
        'ldap_labs_base_dn',
        'ldap_logging',
        'ldap_cache',
        'ifpe_api_url',
        'ifpe_api_token',
        'max_file_upload_size',
        'upload_max_filesize',
        'post_max_size'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}