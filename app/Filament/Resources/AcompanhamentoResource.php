<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcompanhamentoResource\Pages;
use App\Filament\Resources\AcompanhamentoResource\RelationManagers;
use App\Models\Acompanhamento;
use App\Models\Requerimento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcompanhamentoResource extends Resource
{
    protected static ?string $model = Acompanhamento::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-s-ticket';
    protected static ?string $navigationLabel = 'Acompanhamentos';
    //protected static ?string $slug = 'requerimentos';
    protected static ?string $pluralModelLabel = 'Acompanhamentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
                    
                Forms\Components\Select::make('requerimento_id')
                    ->relationship('requerimento', 'id')
                    ->required()
                    ->live()
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->id} - {$record->discente->nome} - {$record->tipo_requerimento->descricao}";
                    })
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (!$state) {
                            return;
                        }
                        
                        $requerimento = Requerimento::with([
                            'discente',
                            'tipo_requerimento',
                            'anexos',
                          //  'observacoes',
                           // 'informacaoComplementar'
                        ])->find($state);
                        
                        if ($requerimento) {
                            $set('discente', $requerimento->discente->nome);
                            $set('tipo_requerimento', $requerimento->tipo_requerimento->descricao);
                            $set('observacoes', $requerimento->observacoes);
                            
                         //   $set('_anexos', $requerimento->anexos->nome_original);
                            //dd('_anexos');

                           // dd($requerimento->anexos->nome_original);

                           $set('_anexos', $requerimento->anexos->map(function ($anexo) {
                            return [
                                'nome_original' => $anexo->nome_original,
                                'caminho' => $anexo->caminho,
                                'tamanho' => filesize(storage_path('app/public/' . $anexo->caminho))
                            ];
                        })->toArray());

                        
                            // Armazena a descrição diretamente no campo que será exibido
                            $set('informacao_complementar_descricao', 
                            $requerimento->informacaoComplementar->descricao ?? '');
                        }
                    }),
                    
                Forms\Components\TextInput::make('discente')
                    ->label('Discente')
                    ->disabled()
                    ->dehydrated(),
                    
                Forms\Components\TextInput::make('tipo_requerimento')
                    ->label('Tipo de Requerimento')
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\Textarea::make('observacoes')
                    ->label('Observações do Requerimento' )
                    ->rows(7)
                    ->disabled()
                    //->required()
                    ->dehydrated()
                    ->maxLength(255),
                    
                    // Seção de Anexos
                // Seção para exibir anexos em formato de tabela
                Forms\Components\Section::make('Anexos do Requerimento')
                
                ->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\View::make('anexos-table')
                                ->hidden(fn (Forms\Get $get) => empty($get('_anexos')))
                                ->columnSpanFull(),
                        ])
                ])
                ->hidden(fn (Forms\Get $get) => empty($get('_anexos')))
                ->columnSpanFull(),
                   
              
                // Seção para exibir informações complementares
                Forms\Components\Section::make('Informações Complementares')
                ->schema([
                    Forms\Components\Textarea::make('informacao_complementar_descricao')
                        ->label('')
                        ->disabled()
                        ->rows(7)
                       
                        ->columnSpanFull(),
                ])
                ->hidden(fn (Forms\Get $get) => empty($get('informacao_complementar_descricao')))
                ->columnSpanFull(),
                    
                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição do acompanhamento')
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\FileUpload::make('anexos')
                    ->label('Anexos')
                    ->multiple()
                    ->directory('acompanhamentos/temp')
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
                    
                Forms\Components\Toggle::make('finalizador')
                    ->label('Finalizar Requerimento?')
                    ->onColor('success')
                    ->offColor('gray'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('requerimento')
                    ->label('Requerimento - Discente - Tipo Requerimento')
                    ->formatStateUsing(function ($record) {
                        return "{$record->requerimento->id} - {$record->requerimento->discente->nome} - {$record->requerimento->tipo_requerimento->descricao}";
                    })
                    ->searchable(['requerimento.id', 'requerimento.discente.nome', 'requerimento.tipo_requerimento.descricao'])
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('descricao')
                ->label('Descrição')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable(),
                Tables\Columns\IconColumn::make('finalizador')
                    ->label('Finalizado?')
                    ->aligncenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data de Criação')
                    ->dateTime(format: 'd/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcompanhamentos::route('/'),
            'create' => Pages\CreateAcompanhamento::route('/create'),
            'view' => Pages\ViewAcompanhamento::route('/{record}'),
            'edit' => Pages\EditAcompanhamento::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}