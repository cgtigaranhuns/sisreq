<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            $config = DB::table('configuracoes')->first();

            if (! $config) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | APP
            |--------------------------------------------------------------------------
            */
            Config::set('nome_instituicao', $config->nome_instituicao ?? config('app.name'));
            Config::set('app.name', $config->mail_from_name ?? config('app.name'));
            Config::set('app.version', $config->versao_sistema ?? null);
            Config::set('app.dt.version', $config->data_atualizacao ?? null);
            Config::set('db.version', $config->versao_db ?? null);
            Config::set('db.dt.version', $config->data_atualizacao_db ?? null);

            /*
            |--------------------------------------------------------------------------
            | MAIL
            |--------------------------------------------------------------------------
            */
            Config::set('mail.default', $config->mail_mailer ?? env('MAIL_MAILER', 'smtp'));
            Config::set('mail.mailers.smtp.host', $config->mail_host ?? env('MAIL_HOST', 'smtp.mailgun.org'));
            Config::set('mail.mailers.smtp.port', $config->mail_port ?? env('MAIL_PORT', 587));
            Config::set('mail.mailers.smtp.username', $config->mail_username ?? env('MAIL_USERNAME'));
            Config::set('mail.mailers.smtp.password', $config->mail_password ?? env('MAIL_PASSWORD'));
            Config::set('mail.mailers.smtp.encryption', $config->mail_encryption ?? env('MAIL_ENCRYPTION', 'tls'));
            Config::set('mail.from.address', $config->mail_from_address ?? env('MAIL_FROM_ADDRESS', 'hello@example.com'));
            Config::set('mail.from.name', $config->mail_from_name ?? env('MAIL_FROM_NAME', 'Example'));
            Config::set('mail.admin', $config->mail_admin ?? env('MAIL_ADMIN', 'Example'));

            /*
            |--------------------------------------------------------------------------
            | LDAP - ADM
            |--------------------------------------------------------------------------
            */
            Config::set('ldap.connections.adm.hosts', [$config->ldap_adm_hostname ?? env('LDAP_ADM_HOSTS', '127.0.0.1')]);
            Config::set('ldap.connections.adm.username', $config->ldap_adm_username ?? env('LDAP_ADM_USERNAME'));
            Config::set('ldap.connections.adm.password', $config->ldap_adm_password ?? env('LDAP_ADM_PASSWORD'));
            Config::set('ldap.connections.adm.base_dn', $config->ldap_adm_base_dn ?? env('LDAP_ADM_BASE_DN'));
                /*
            |--------------------------------------------------------------------------
            | LDAP - LABS
            |--------------------------------------------------------------------------
            */
            Config::set('ldap.connections.labs.hosts', [$config->ldap_labs_hostname ?? env('LDAP_LABS_HOSTS', '127.0.0.1')]);
            Config::set('ldap.connections.labs.username', $config->ldap_labs_username ?? env('LDAP_LABS_USERNAME'));
            Config::set('ldap.connections.labs.password', $config->ldap_labs_password ?? env('LDAP_LABS_PASSWORD'));
            Config::set('ldap.connections.labs.base_dn', $config->ldap_labs_base_dn ?? env('LDAP_LABS_BASE_DN'));


            /*
            |--------------------------------------------------------------------------
            | LDAP - GERAL
            |--------------------------------------------------------------------------
            */
            Config::set('ldap.logging', (bool) $config->ldap_logging ?? true);
            Config::set('ldap.cache', (bool) $config->ldap_cache ?? false);

            /*
            |--------------------------------------------------------------------------
            | IFPE API
            |--------------------------------------------------------------------------
            */
            Config::set('services.ifpe_api.url', $config->ifpe_api_url ?? env('IFPE_API_URL'));
            Config::set('services.ifpe_api.token', $config->ifpe_api_token ?? env('IFPE_API_TOKEN'));


            /*
            |--------------------------------------------------------------------------
            | UPLOAD
            |--------------------------------------------------------------------------
            */
            Config::set('filesystems.max_file_upload_size', $config->max_file_upload_size ?? env('MAX_FILE_UPLOAD_SIZE', 2048));
            Config::set('php.upload_max_filesize', $config->upload_max_filesize ?? env('UPLOAD_MAX_FILESIZE', '2M'));
            Config::set('php.post_max_size', $config->post_max_size ?? env('POST_MAX_SIZE', '8M'));

        } catch (\Throwable $e) {
            // Evita quebrar o deploy se a tabela não existir ainda
            logger()->error('Erro ao carregar DynamicConfigServiceProvider: ' . $e->getMessage());
        }
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        // Carrega o helper early
    //    require_once app_path('Helpers/ConfigHelper.php');

      
    }

    
}