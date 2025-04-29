<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequerimentoResource\Pages;
use App\Filament\Resources\RequerimentoResource\RelationManagers;
use App\Filament\Resources\RequerimentoResource\Pages\ListRequerimentos;
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
                    
                        //->relationship('discente', 'nome')
                        ->relationship(
                            name: 'discente',
                            titleAttribute: 'nome',
                            modifyQueryUsing: fn (Builder $query) => auth()->user()->hasRole('Discente') 
                                ? $query->where('matricula', auth()->user()->matricula) // Filtra por matrícula do usuário
                                : $query
                        )
                    ->required()
                    ->searchable()
                    ->preload()
                    //->readonly(fn () => auth()->user()->hasRole('Discente')) // Desabilita se for Discente
                    ->default(
                        fn () => auth()->user()->hasRole('Discente')
                            ? Discente::where('matricula', auth()->user()->matricula)->first()?->id 
                            : null
                     ) ,
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
                    ->maxSize(5120) // 5MB
                    ->columnSpanFull()
                    ->hidden(function (Forms\Get $get) {
                        $tipoId = $get('tipo_requerimento_id');
                        if (!$tipoId) {
                            return true;
                        }
                        
                        $tipoRequerimento = Tipo_requerimento::find($tipoId);
                        return $tipoRequerimento->anexo === null;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->paginated(false)
      /*  ->modifyQueryUsing(function (Builder $query) {
            $user = auth()->user();
            // Se o usuário for do perfil "usuário", filtra os registros pelo user_id
            if ($user->hasRole('Discente')) {
                $query->where('user_id', $user->id)->orderBY('id', 'desc'); 
            }else {
               $query->orderBY('id', 'desc');
            }
        })
            ->striped()*/
            ->columns([
               /*Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discente.nome')
                    //->numeric()
                    ->limit(35)
                    ->sortable(),
                    Tables\Columns\TextColumn::make('discente.matricula')
                    ->label('Matricula')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                    ->Label('Tipo do Requerimento')
                    ->limit(35)
                    ->sortable(),
                Tables\Columns\TextColumn::make('anexos_count')
                    ->label('Anexos')
                    ->aligncenter()
                    ->counts('anexos'),
                /*Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
               /* Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime(format: 'd/m/Y')
                    ->sortable(),*/
                  //  ->toggleable(isToggledHiddenByDefault: true),
                /*Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),*/
               /* Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'danger',
                        'em_analise' => 'warning',
                        'finalizado' => 'success',
                    })
                    ->searchable(),*/
            ])
            ->filters([
              ///  Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
             /*   Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
                //->label('')
                ->tooltip('Excluir'),*/
            ])
            ->bulkActions([
             /*   Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),*/
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnexosRelationManager::class,
            RelationManagers\InformacaoComplementarRelationManager::class,
            RelationManagers\AcompanhamentosRelationManager::class,
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

}