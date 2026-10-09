<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Repeater::make('subscriptions')
                    ->relationship()
                    ->simple(
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->searchable(true)
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    )
                    ->reorderable(false),
            ]);
    }
}
