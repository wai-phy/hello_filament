<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use App\Models\Category;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create A Post')
                ->collapsible()
                ->description('Hello Create here your post')
                ->schema([
                    TextInput::make('title')->rules('min:3|max:5')->required(),
                    TextInput::make('slug')->required(),
                    Select::make('category_id')
                        ->label('Category')
                        ->options(Category::all()
                        ->pluck('name','id')),
                    ColorPicker::make('color')->required(),
                    MarkdownEditor::make('content')->required()->columnSpanFull(),
                ])->columnSpan(2)->columns(2),
                Group::make()->schema([
                            Section::make('Meta')
                        ->description('Meata Post')
                        ->collapsible()
                        ->schema([
                            FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                            
                        ])->columnSpan(1),
                            TagsInput::make('tags')->required(),
                            Checkbox::make('published'),
                ])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault:true),
                ImageColumn::make('thumbnail')
                ->toggleable(),
                ColorColumn::make('color')
                ->toggleable(),
                TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->toggleable(),
                TextColumn::make('slug')
                ->sortable()
                ->searchable()
                ->toggleable(),
                TextColumn::make('category.name')
                ->sortable()
                ->searchable()
                ->toggleable(),
                TextColumn::make('tags')
                ->toggleable(),
                CheckboxColumn::make('published')
                ->toggleable(),
                TextColumn::make('created_at')->label('Published On')->sortable()


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
