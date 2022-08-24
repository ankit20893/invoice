<?php

namespace App\Nova;

use App\Nova\Actions\BillGenerate;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Pdmfc\NovaFields\ActionButton;

class Enterprise extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Enterprise::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Textarea::make('Address')
            ->rules('required'),
            Text::make('Email')->onlyOnForms(),
            Text::make('Owner Name', 'owner_name')->onlyOnForms(),
            Text::make('G.R. No.', 'gr_no')->onlyOnForms(),
            Text::make('GST Number', 'gst_no')->rules('required'),
            Text::make('PAN Number', 'pan_no')->rules('required'),
            Boolean::make('Status')
                ->default(true)
            ->sortable(),
            MorphMany::make('phones')->rules('required'),
            MorphMany::make('banks')->rules('required'),
            HasMany::make('invoices'),
            ActionButton::make('Action')->text('Generate Invoice')
                ->action(BillGenerate::class, $this->id)->onlyOnIndex()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new BillGenerate)->confirmButtonText('Generate Bill'),
        ];
    }
}
