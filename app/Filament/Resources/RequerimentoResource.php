<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequerimentoResource\Pages;
use App\Filament\Resources\RequerimentoResource\RelationManagers;
use App\Filament\Resources\RequerimentoResource\Pages\ListRequerimentos;
use App\Models\Requerimento;
use App\Models\Discente;
use App\Models\TipoRequerimento;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
//use Closure;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;

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
                    ->label('Discente')
                        //->relationship('discente', 'nome')
                        ->options(function () {
                        $query = \App\Models\Discente::query()->orderBy('nome');
                        
                        if (auth()->user()->hasRole('Discente')) {
                            $query->where('matricula', auth()->user()->matricula);
                        }

                        return $query->get()->mapWithKeys(function ($discente) {
                            return [
                                $discente->id => "{$discente->nome} - {$discente->matricula}"
                            ];
                        });
                    })
                    ->required()
                    ->searchable(['nome', 'matricula'])
                    ->preload()
                    //->readonly(fn () => auth()->user()->hasRole('Discente')) // Desabilita se for Discente
                    ->default(
                        fn () => auth()->user()->hasRole('Discente')
                            ? Discente::where('matricula', auth()->user()->matricula)->first()?->id 
                            : null
                     ) ,
                Forms\Components\Select::make('tipo_requerimento_id')
                    ->label('Tipo do Requerimento')
                    ->relationship(
                        name: 'tipo_requerimento',
                        titleAttribute: 'descricao',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->where('status', true)
                            ->orderBy('descricao')
                    )
                    //->relationship('tipo_requerimento', 'descricao')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live() // Adiciona reactividade
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $tipoRequerimento = TipoRequerimento::find($state);
                            $set('anexo', $tipoRequerimento->anexo ?? '');
                            $set('descricao_complementar', $tipoRequerimento->template ?? '');
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

                
               Forms\Components\Toggle::make('processo_sei')
                    ->required()
                    ->label('Processo SEI')
                    //->maxLength(255)
                    ->default(false)
                    ->visible(fn () => (!auth()->user()->hasRole('Discente')))
                    ->reactive(),

                Forms\Components\TextInput::make('num_processo')
                    ->required()
                    ->maxLength(255)
                    ->visible(fn (Get $get) => $get('processo_sei') === true && (!auth()->user()->hasRole('Discente')))
                    ->label('Número do Processo no SEI'),

                    // informações complementares

                    // Botão para ativar informações complementares
                Forms\Components\Toggle::make('tem_informacoes_complementares')
                ->label('Adicionar informações complementares?')
                ->live()
                ->visible(false)
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    if (!$state) {
                       // $tipoRequerimento = Tipo_requerimento::find($state);
                      //  $set('descricao_complementar', $tipoRequerimento->template ?? '');
                       // $set('status_complementar', null);
                    }
                }),
            
                // Campos condicionais para informações complementares
                Forms\Components\Fieldset::make('Informações Complementares')
                    ->schema([
                        Forms\Components\Textarea::make('descricao_complementar')
                            ->label('')
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
                    ->maxSize(102400) // 5MB
                    ->columnSpanFull()
                    ->hidden(function (Forms\Get $get, string $operation) {
                    // Esconde sempre na edição
                    if ($operation === 'edit') {
                        return true;
                    }
                    
                    // Na criação, aplica a regra do tipo de requerimento
                    $tipoId = $get('tipo_requerimento_id');
                    if (!$tipoId) {
                        return true;
                    }
                    
                    $tipoRequerimento = TipoRequerimento::find($tipoId);
                    return $tipoRequerimento->anexo === null;
                })
                        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->paginated(false)
      
            ->columns([
              
            ])
            ->filters([
              
            ])
            ->actions([
             
            ])
            ->bulkActions([
            
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnexosRelationManager::class,
            RelationManagers\InformacaoComplementarRelationManager::class,
            RelationManagers\AcompanhamentosRelationManager::class,
            RelationManagers\ComunicacaoRelationManager::class,
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

    public static function getWidgets(): array
{
    return [
        \App\Filament\Resources\RequerimentoResource\Widgets\RequerimentosPendentes::class,
        \App\Filament\Resources\RequerimentoResource\Widgets\RequerimentosEmAnalise::class,
        \App\Filament\Resources\RequerimentoResource\Widgets\RequerimentosFinalizados::class,
    ];
}
public static function canView(Model $record): bool
{
    return Gate::allows('view', $record);
}

public static function canEdit(Model $record): bool
{
    return Gate::allows('update', $record);
}


}