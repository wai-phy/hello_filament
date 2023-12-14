<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Pages\Actions;
use Filament\Forms\Components\Tabs\Tab;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs():array
    {
        return [
            'All' => Tab::make('All'),
            'Published' => Tab::make('Published')->query(function (Builder $query){
                $query->where('published',true);
            }),

            'UnPublished' => Tab::make('Published')->query(function (Builder $query){
                $query->where('published',false);
            })
        ];
    }
}
