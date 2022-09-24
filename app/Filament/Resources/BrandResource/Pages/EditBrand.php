<?php

namespace App\Filament\Resources\BrandResource\Pages;

use Filament\Pages\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BrandResource;
use Filament\Forms\Components\MarkdownEditor;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
