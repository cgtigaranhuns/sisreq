<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfiguracoeResource\Pages;
use App\Filament\Resources\ConfiguracoeResource\RelationManagers;
use App\Models\Configuracoe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;


class ConfiguracoeResource extends Resource
{
    protected static ?string $model = Configuracoe::class;
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-s-cog-8-tooth';
    protected static ?string $navigationLabel = 'Parâmetros';
    protected static ?string $slug = 'parametros';
    protected static ?string $pluralModelLabel = 'Parâmetros';
    
    public static function form(Form $form): Form
    {
        return $form
         
            ->schema([
                Section::make('')
                    ->schema([
                    Fieldset::make('Dados da Instituição')
                        ->schema([
                            Forms\Components\TextInput::make('nome_instituicao')
                                ->label('Nome da Instituição')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('endereco_instituicao')
                                ->label('Endereço da Instituição')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('contato_instituicao')
                                ->label('Contato da Instituição')
                                ->maxLength(255),
                        ])
                        ->columns(3),
                        Fieldset::make('Versão do Sistema e BD')
                        ->schema([
                            Forms\Components\TextInput::make('versao_sistema')
                                ->label('Versão do Sistema')
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('data_atualizacao')
                                ->label('Data da Atualização'),
                            Forms\Components\TextInput::make('versao_db')
                                ->label('Versão do Banco de Dados')
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('data_atualizacao_db')
                                ->label('Data da Atualização do DB'),
                        ]),
                        Section::make('E-mail')
                    ->schema([
                        Fieldset::make('Configurações do Servidor')
                          ->schema([
                            Forms\Components\TextInput::make('mail_mailer')
                                ->label('Driver do e-mail')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('mail_host')
                                ->label('Host do e-mail')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('mail_port')
                                ->label('Porta do e-mail')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('mail_encryption')
                                ->label('Criptografia (tls/ssl)')
                                ->maxLength(255),
                          ])
                          ->columns(4),
                            Fieldset::make('Configurações do usuário do e-mail')
                          ->schema([
                            Forms\Components\TextInput::make('mail_username')
                                ->label('Usuário do e-mail')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('mail_password')
                                ->label('Senha do e-mail')
                                ->password()
                                ->maxLength(255),
                            
                            Forms\Components\TextInput::make('mail_from_address')
                                ->label('E-mail do Remetente')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('mail_from_name')
                                ->label('Nome do Remetente')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('mail_admin')
                                ->label('E-mail do Administrador')
                                ->maxLength(255),
                          
                          ])
                            ->columns(3),
                          ]),
                           Section::make('Configurações LDAP e API')
                            ->schema([
                          Fieldset::make('LDAP Admin')
                        ->schema([
                            Forms\Components\TextInput::make('ldap_adm_hostname')
                                ->label('Hostname/IP')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ldap_adm_username')
                                ->label('Usuário')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ldap_adm_password')
                                ->label('Senha')
                                ->password()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ldap_adm_base_dn')
                                ->label('Base DN')
                                ->maxLength(255),
                        ])
                        ->columns(4),
                        Fieldset::make('LDAP Labs')
                        ->schema([
                            Forms\Components\TextInput::make('ldap_labs_hostname')
                                ->label('Hostname/IP')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ldap_labs_username')
                                ->label('Usuário')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ldap_labs_password')
                                ->label('Senha')
                                ->password()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ldap_labs_base_dn')
                                ->label('Base DN')
                                ->maxLength(255),
                        ])
                        ->columns(4),
                        
                        Fieldset::make('API Q-Acadêmico')
                        ->schema([
                            Forms\Components\TextInput::make('ifpe_api_url')
                                ->label('URL')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('ifpe_api_token')
                                ->label('Token')
                                ->password()
                                ->maxLength(255),
                        ])
                    ]),
                        Fieldset::make('Outros')
                        ->schema([
                            
                            Forms\Components\TextInput::make('max_file_upload_size')
                                ->label('Tamanho máximo de upload de arquivos (KB)')
                                ->required()
                                ->numeric()
                                ->default(2048),
                            Forms\Components\TextInput::make('upload_max_filesize')
                                ->label('Tamanho máximo de upload de arquivos (MB)')
                                ->required()
                                ->maxLength(255)
                                ->default(8),
                            Forms\Components\TextInput::make('post_max_size')
                                ->label('Tamanho máximo de upload de arquivos (MB)')
                                ->required()
                                ->maxLength(255)
                                ->default(8),
                                Forms\Components\Toggle::make('ldap_logging')
                                ->label('Ativar Log de Autenticação LDAP')
                                ->required(),
                            Forms\Components\Toggle::make('ldap_cache')
                                ->label('Ativar Cache LDAP')
                                ->required(),
                        ])
                        ->columns(3)
            ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('nome_instituicao')
                    ->label('Instituição'),
                Tables\Columns\TextColumn::make('versao_sistema')
                    ->label('Versão do Sistema'),
                Tables\Columns\TextColumn::make('data_atualizacao')
                    ->date(format: 'd/m/Y')
                    ->label('Data Atualização'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->tooltip('Editar'),
            ]);
    }

    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConfiguracoes::route('/'),
            'edit' => Pages\EditConfiguracoe::route('/{record}/edit'),
        ];
    }

    
}