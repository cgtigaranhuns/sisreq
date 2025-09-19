<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_instituicao')->nullable();
            $table->string('endereco_instituicao')->nullable();
            $table->string('contato_instituicao')->nullable();
            $table->string('versao_sistema')->nullable();
            $table->date('data_atualizacao')->nullable();
            $table->string('logo_instituicao')->nullable();
            $table->string('versao_db')->nullable();
            $table->date('data_atualizacao_db')->nullable();
            $table->string('mail_mailer')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->string('mail_admin')->nullable();
            $table->string('ldap_adm_hostname')->nullable();
            $table->string('ldap_adm_username')->nullable();
            $table->string('ldap_adm_password')->nullable();
            $table->string('ldap_adm_base_dn')->nullable();
            $table->string('ldap_labs_hostname')->nullable();
            $table->string('ldap_labs_username')->nullable();
            $table->string('ldap_labs_password')->nullable();
            $table->string('ldap_labs_base_dn')->nullable();
            $table->boolean('ldap_logging')->default(true);
            $table->boolean('ldap_cache')->default(false);
            $table->string('ifpe_api_url')->nullable();
            $table->string('ifpe_api_token')->nullable();
            $table->integer('max_file_upload_size')->default(2048);
            $table->string('upload_max_filesize')->default('8');
            $table->string('post_max_size')->default('8');
            $table->softDeletes();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};