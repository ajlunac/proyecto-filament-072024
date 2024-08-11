<?php

namespace App\Filament\Personal\Pages;

use Filament\Pages\Page;

class Custom extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.personal.pages.custom';
}
