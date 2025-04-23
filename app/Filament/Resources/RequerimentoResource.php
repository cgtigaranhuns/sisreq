<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequerimentoResource\Pages;
use App\Filament\Resources\RequerimentoResource\RelationManagers;
use App\Models\Requerimento;
use App\Models\Discente;
use App\Models\Tipo_requerimento;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequerimentoResource extends Resource
{
    protected static ?string $model = Requerimento::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-s-document-arrow-down';
    protected static ?string $navigationLabel = 'Requerimentos';
    protected static ?string $slug = 'requerimentos';
    protected static ?string $pluralModelLabel = 'Requerimentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id') // Campo oculto para o user_id
                    ->default(auth()->id()) // Preenche automaticamente com o ID do usuário logado
                    ->required(),
                Forms\Components\Select::make('discente_id')
                    ->relationship('discente', 'nome')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('tipo_requerimento_id')
                    ->label('Tipo do Requerimento')
                    ->relationship('tipo_requerimento', 'descricao')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live() // Adiciona reactividade
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $tipoRequerimento = Tipo_requerimento::find($state);
                            $set('anexo', $tipoRequerimento->anexo ?? '');
                            // Define o estado do toggle com base no valor de infor_complementares
                            $set('tem_informacoes_complementares', $tipoRequerimento->infor_complementares ?? false);
                        }
                    }),
                    Textarea::make('observacoes')
                    ->label('Observações' )
                    ->rows(7)
                   
                    ->maxLength(255),
               
                Textarea::make('anexo')
                    ->label('Anexo(s) - Documentos exigidos' )
                    ->rows(7)
                    ->disabled()
                    //->required()
                    ->dehydrated()
                    ->maxLength(255),

                
               /* Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('pendente'),*/

                    // informações complementares

                    // Botão para ativar informações complementares
                Forms\Components\Toggle::make('tem_informacoes_complementares')
                ->label('Adicionar informações complementares?')
                ->live()
                ->visible(false)
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    if (!$state) {
                        $set('descricao_complementar', null);
                       // $set('status_complementar', null);
                    }
                }),
            
                // Campos condicionais para informações complementares
                Forms\Components\Fieldset::make('Informações Complementares')
                    ->schema([
                        Forms\Components\Textarea::make('descricao_complementar')
                            ->label('Descrição')
                            ->rows(7)
                            ->hidden(fn (Forms\Get $get): bool => !$get('tem_informacoes_complementares')),
                    
                    ])
                    ->hidden(fn (Forms\Get $get): bool => !$get('tem_informacoes_complementares')),

                Forms\Components\FileUpload::make('anexos')
                    ->label('Anexos')
                    ->multiple()
                    ->directory('requerimentos/temp')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->acceptedFileTypes([
                        'application/pdf',
                        'image/*',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ])
                    ->maxSize(5120) // 5MB
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discente.nome')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('discente.matricula')
                    ->label('Matricula')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                    ->numeric()
                    ->sortable(),
                /*Tables\Columns\TextColumn::make('observacoes')
                    ->searchable(),*/
               
                Tables\Columns\TextColumn::make('anexos_count')
                    ->label('Anexos')
                    ->aligncenter()
                    ->counts('anexos'),
                   
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
               /* Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime(format: 'd/m/Y')
                    ->sortable(),*/
                  //  ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'danger',
                        'em_analise' => 'warning',
                        'finalizado' => 'success',
                    })
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnexosRelationManager::class,
            RelationManagers\InformacaoComplementarRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequerimentos::route('/'),
            'create' => Pages\CreateRequerimento::route('/create'),
            'view' => Pages\ViewRequerimento::route('/{record}'),
            'edit' => Pages\EditRequerimento::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $requerimento = parent::handleRecordCreation($data);
    
        if (isset($data['anexos']) && is_array($data['anexos'])) {
            foreach ($data['anexos'] as $anexoPath) {
                try {
                    // Define o diretório específico para o requerimento
                    $diretorioRequerimento = 'requerimentos/anexos/' . $requerimento->id;
                    
                    // Obtém o nome original do arquivo
                    $nomeOriginal = basename($anexoPath);
                    
                    // Gera um nome único para o arquivo
                    $nomeUnico = uniqid() . '_' . $nomeOriginal;
                    
                    // Cria o caminho final
                    $caminhoFinal = $diretorioRequerimento . '/' . $nomeUnico;
                    
                    // Move o arquivo para o diretório do requerimento
                    \Illuminate\Support\Facades\Storage::disk('public')
                        ->move($anexoPath, $caminhoFinal);
                    
                    // Salva no banco de dados
                    Anexo::create([
                        'requerimento_id' => $requerimento->id,
                        'caminho' => $caminhoFinal,
                        'nome_original' => $nomeOriginal,
                        'mime_type' => \Illuminate\Support\Facades\Storage::disk('public')->mimeType($caminhoFinal),
                        'tamanho' => \Illuminate\Support\Facades\Storage::disk('public')->size($caminhoFinal),
                    ]);
                } catch (\Exception $e) {
                    logger()->error('Erro ao salvar anexo: ' . $e->getMessage());
                    continue;
                }
            }
        }
    
        return $requerimento;
    }
}