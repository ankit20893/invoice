<?php

namespace App\Nova\Actions;

use App\Models\Invoice;
use App\Models\OtherEnterprise;
use Barryvdh\DomPDF\Facade\Pdf;
use DigitalCreative\ConditionalContainer\ConditionalContainer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class BillGenerate extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Indicates if this action is only available on the resource index view.
     *
     * @var bool
     */
    public $onlyOnIndex = false;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        /*$id = uniqid();
        $path = '/app/public/pdf/'. $id .'.pdf';

        $pdf = Pdf::loadView('bill-template.first-enterprise')->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->save(storage_path($path));*/

       /* return Action::redirect('/download?path='.$path);*/
        /**/
        /*return $pdf->download('articles.pdf');*/
        $invoice = null;
        foreach ($models as $model) {
            $data = $fields->toArray();
            $data['enterprise_id'] = $model->id;
            $data['gr_no'] = $model->gr_no;
            $invoice = Invoice::create($data);

            $model->gr_no = $model->gr_no + 1;
            $model->save();
        }

         return Action::redirect('/download/'.$invoice->id);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $otherEnterprises = OtherEnterprise::all()->pluck('name','id');
        return [
            Date::make('Date', 'date')->rules('required'),
            Text::make('Bill No.', 'bill_no')->rules('required'),
            Text::make('From')->rules('required'),
            Text::make('To')->rules('required'),
            Text::make('Truck No.', 'truck_no')->rules('required'),
            Text::make('Driver Name', 'driver_name')->rules('required'),
            Select::make('Consigner', 'consigner_id')->options($otherEnterprises)->rules('required'),
            Select::make('Consignee', 'consignee_id')->options($otherEnterprises)->rules('required'),
            Select::make('Delivery', 'delivery_id')->options($otherEnterprises)->rules('required'),
            Number::make('No. of Packets', 'no_of_packets')->rules('required'),
            Text::make('HSV/SAC Code', 'hsv_sac_code')->rules('required'),
            Text::make('Description')->rules('required'),
            Text::make('To Pay', 'to_pay'),
            Text::make('Weight')->rules('required'),
            Text::make('Rate')->rules('required'),
            Text::make('Value of Goods', 'value_of_goods')->rules('required'),
            Boolean::make('GST', 'is_gst'),
            ConditionalContainer::make([ Boolean::make('IGST', 'igst') ])
                ->if('is_gst = 1'),
            ConditionalContainer::make([ Text::make('GST Percentage', 'gst_percentage') ])
                ->if('is_gst = 1'),
            Text::make('Advance'),
        ];
    }
}
