<?php

namespace App\DataTables;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'report.action')
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Report $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('report-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'print', 'reset', 'reload'],
            ])
            ->buttons([
                Button::make('add'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Place DT_RowIndex first for a serial number column
            Column::make('DT_RowIndex')
                ->title('စဉ်') // Or 'No.'
                ->exportable(false) // Don't export this column
                ->printable(false)  // Don't print this column
                ->width(30)
                ->addClass('text-center'),

            Column::make('cargo_no')->title('ကုန်အမှတ်'),
            Column::make('from')->title('မှ မြို့ နှင့် ဂိတ်'),
            Column::make('to')->title('သို့ မြို့ နှင့် ဂိတ်'),
            Column::make('s_name')->title('ပို့သူ'),
            Column::make('s_phone')->title('ပို့သူဖုန်းနံပါတ်'),
            Column::make('s_address')->title('ပို့သူလိပ်စာ'),
            Column::make('r_name')->title('လက်ခံသူနာမည်'),
            Column::make('r_phone')->title('လက်ခံသူဖုန်းနံပါတ်'),
            Column::make('r_address')->title('လက်ခံသူလိပ်စာ'),
            Column::make('created_at')->title('ကုန်စာရင်းသွင်းရက်'),
            Column::make('to_pick_date')->title('ကုန်းရွေးရမည့်ရက်'),
            Column::make('quantity')->title('ကုန်ပစ္စည်းအရေအတွက်'),
            Column::make('service_charge')->title('တန်ဆာခ'),
            Column::make('short_deli_fee')->title('ခေါက်တိုကြေး'),
            Column::make('final_deli_fee')->title('အရောက်ပို့ကြေး'),
            Column::make('border_fee')->title('ဘော်ဒါကြေး'),
            Column::make('total_fee')->title('ကျသင့်ငွေစုစုပေါင်း'),
            Column::make('instant_cash')->title('လက်ငင်းငွေသား'),
            Column::make('loan_cash')->title('အကြွေးငွေသား'),
            Column::make('voucher_number')->title('ဘောက်ချာနံပါတ်'),

            // Place the 'action' column last, as it often appears on the right
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->title('လုပ်ဆောင်ချက်'), // Added a title for the action column
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Report_' . date('YmdHis');
    }
}
