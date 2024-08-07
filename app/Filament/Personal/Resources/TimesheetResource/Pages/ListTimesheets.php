<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {

        $lastTimesheet = Timesheet::where('user_id', Auth::user()->id)->orderBy('id','desc')->first();

        if($lastTimesheet == null){
            return [
                Action::make('inWork')
                    ->label('Entrar a trabajar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (){
                        $user = Auth::user();
                        $timesheet = new Timesheet();
                        $timesheet->calendar_id = 1;
                        $timesheet->user_id = $user->id;
                        $timesheet->day_in = Carbon::now();
                        $timesheet->type = 'work';
                        $timesheet->save();
                    }),
                Actions\CreateAction::make(),
            ];
        }

        return [
            Action::make('inWork')
                ->label('Entrar a trabajar')
                ->color('success')
                ->visible(!$lastTimesheet->day_out == null)
                ->disabled($lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function (){
                    $user = Auth::user();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = $user->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'work';
                    $timesheet->save();

                    Notification::make()
                        ->title('Has entrado a trabajar')
                        ->success()
                        ->color('success')
                        ->send();
                }),
            Action::make('stopWork')
                ->label('Parar de trabajar')
                ->color('success')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type!='pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function () use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();

                    Notification::make()
                        ->title('Has parado a trabajar')
                        ->success()
                        ->color('success')
                        ->send();
                }),
            Action::make('inPause')
                ->label('Comenzar Pausa')
                ->color('info')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type!='pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'pause';
                    $timesheet->save();

                    Notification::make()
                        ->title('Comienzas tu pausa')
                        ->info()
                        ->color('info')
                        ->send();
                }),
            Action::make('stopPause')
                ->label('Parar Pausa')
                ->color('info')
                ->visible($lastTimesheet->day_out == null && $lastTimesheet->type=='pause')
                ->disabled(!$lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'work';
                    $timesheet->save();

                    Notification::make()
                        ->title('Comienzas de nuevo a trabajar')
                        ->info()
                        ->color('info')
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
