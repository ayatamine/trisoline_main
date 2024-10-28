<?php

namespace App\Filament\Admin\Widgets;

use Filament\Forms;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions\EditAction;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalenderWidget extends FullCalendarWidget
{
    protected static string $chartId = 'Events';
    protected int | string | array $columnSpan = 2;
    protected static ?string $maxHeight = '300px';
    protected static ?int $sort = 8;
    public Model | string | null $model = Event::class;
    public function fetchEvents(array $fetchInfo): array
    {
        
        return Event::query()
            ->where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start,
                    'end' => $event->end,
                    'allDay' => $event->allDay
                ]
            )
            ->all();
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create event') // change the label of the button
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        
                        $form->fill([
                            'name' => $arguments['name'] ?? null, // if a date is selected it will autofill
                            'start' => $arguments['start'] ?? null, // if a date is selected it will autofill
                            'end' => $arguments['end'] ?? null,
                            'allDay' => true, // the default is an all day event
                        ]);
                    }
                )
        ];
    }
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->label(trans('dash.name')),
 
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\DateTimePicker::make('start')->label(trans('dash.starts_at')),
 
                    Forms\Components\DateTimePicker::make('end')->label(trans('dash.ends_at')),
                ]),
        ];
    }
    protected function modalActions(): array
    {
        return [
            EditAction::make()
                ->mountUsing(
                    function (Event $record, Form $form, array $arguments) {
                        $form->fill([
                            'title' => $record->name,
                            'start' => $record->start,
                            'end'   => $record->end,
                            'allDay' => $record->allDay,
                        ]);
                    }
                ),
            DeleteAction::make(),
        ];
    }
    public function eventDidMount(): string
{
    return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.name+"' }");
        }
    JS;
}
}
