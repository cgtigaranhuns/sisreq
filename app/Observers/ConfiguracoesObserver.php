<?php

namespace App\Observers;

use App\Models\Configuracao;

class ConfiguracoesObserver
{
    /**
     * Quando criar ou atualizar um registro na tabela.
     */
    public function saved(Configuracao $config): void
    {
        $this->applyConfig($config);
    }

    /**
     * Quando deletar um registro (opcional).
     */
    public function deleted(Configuracao $config): void
    {
        // Aqui você pode resetar para valores do .env
    }

    /**
     * Aplica os valores no Laravel Config.
     */
    private function applyConfig(Configuracao $config): void
    {
        // 🔹 App
        Config::set('nome_instituicao', $config->nome_instituicao );
        Config::set('app.name', $config->mail_from_name);
        Config::set('app.version', $config->versao_sistema );
         Config::set('app.dt.version', $config->data_atualizacao);
         Config::set('db.version', $config->versao_db);
        Config::set('db.dt.version', $config->data_atualizacao_db);
        // 🔹 Mail
        Config::set('mail.default', $config->mail_mailer);
        Config::set('mail.mailers.smtp.host', $config->mail_host);
        Config::set('mail.mailers.smtp.port', $config->mail_port);
        Config::set('mail.mailers.smtp.username', $config->mail_username);
        Config::set('mail.mailers.smtp.password', $config->mail_password);
        Config::set('mail.mailers.smtp.encryption', $config->mail_encryption);
        Config::set('mail.from.address', $config->mail_from_address);
        Config::set('mail.from.name', $config->mail_from_name);
        Config::set('mail.admin', $config->mail_admin);

        // 🔹 LDAP ADM
        Config::set('ldap.connections.adm.hosts', [$config->ldap_adm_hostname]);
        Config::set('ldap.connections.adm.username', $config->ldap_adm_username);
        Config::set('ldap.connections.adm.password', $config->ldap_adm_password);
        Config::set('ldap.connections.adm.base_dn', $config->ldap_adm_base_dn);

        // 🔹 LDAP LABS
        Config::set('ldap.connections.labs.hosts', [$config->ldap_labs_hostname]);
        Config::set('ldap.connections.labs.username', $config->ldap_labs_username);
        Config::set('ldap.connections.labs.password', $config->ldap_labs_password);
        Config::set('ldap.connections.labs.base_dn', $config->ldap_labs_base_dn);

        // 🔹 API IFPE
        Config::set('services.ifpe_api.url', $config->ifpe_api_url);
        Config::set('services.ifpe_api.token', $config->ifpe_api_token);

        // 🔹 Upload
        Config::set('filesystems.max_file_upload_size', $config->max_file_upload_size);
        Config::set('php.upload_max_filesize', $config->upload_max_filesize);
        Config::set('php.post_max_size', $config->post_max_size);
    }
}