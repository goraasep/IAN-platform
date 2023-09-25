<?php

namespace App\Exports;

use App\Models\Dashboard;
use App\Models\Parameters;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\BeforeWriting;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart as ChartChart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class DashboardExport implements WithEvents, Responsable
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;
    protected $parameter;
    private $fileName = 'test.xlsx';
    private $writerType = Excel::XLSX;
    public function __construct($request)
    {
        // $datetimeexplode = explode(' to ', $request->input('datetimerange'));
        // $start = $datetimeexplode[0];
        // $end = $datetimeexplode[1];
        $this->parameter = [
            // 'from' => $start,
            // 'to' => $end,
            'dashboard_id' => 1,
        ];
        // $this->fileName = $this->parameter['from'] . '_to_' . $this->parameter['to'] . '_' . $this->parameter['parameter_name'] . '.xlsx';
        $this->fileName = 'test.xlsx';
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {

                // $templateFile = new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('template.xlsx'));
                // $event->writer->reopen($templateFile, Excel::XLSX);
                $dashboard = Dashboard::with(['panels' => function ($panels) {
                    $panels->orderBy('order', 'ASC');
                    $panels->with(['parameter']);
                }])->find($this->parameter['dashboard_id']);
                $i = 1;
                foreach ($dashboard->panels as $panel) {
                    $event->writer->createSheet();
                    $sheet = $event->writer->getSheetByIndex($i);
                    $sheet->setTitle($panel->parameter->name);
                    $this->populateSheet($sheet, $panel->parameter);
                    $this->populateSheet2($sheet, $panel->parameter);
                    $i++;
                }

                $sheet = $event->writer->getSheetByIndex(0);
                $sheet->setTitle('Overview');
                $workSheet =  $sheet->getDelegate();
                // $this->getDrawing()->setWorksheet($workSheet);
                $this->charts()->setWorksheet($workSheet);
                // foreach ($this->charts() as $chart) {
                //     $chart->setWorksheet($workSheet);
                // }
                // $this->populateSheet($sheet);

                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }
    public function getDrawing()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(storage_path('iot_croped.png'));
        $drawing->setHeight(50);
        // $drawing->setWidth(200);
        $drawing->setOffsetX(65);
        $drawing->setOffsetY(10);
        $drawing->setResizeProportional(TRUE);
        $drawing->setCoordinates('A1');
        return $drawing;
    }

    public function charts()
    {
        $dashboard = Dashboard::with(['panels' => function ($panels) {
            $panels->orderBy('order', 'ASC');
            $panels->with(['parameter']);
        }])->find($this->parameter['dashboard_id']);
        $i = 0;
        $charts = [];
        foreach ($dashboard->panels as $panel) {
            $parameter = $panel->parameter;
            $parameter_count = DB::table('parameter_log_' . $parameter->id)
                ->select('created_at', 'log_value')
                // ->where([
                //     ['created_at', '>=', $this->parameter['from']],
                //     ['created_at', '<=', $this->parameter['to']],
                // ])
                ->orderBy('created_at', 'desc')
                ->count();
            $label      = [new DataSeriesValues('String', $parameter->name . '!$B$1', null, 1)];
            $categories = [new DataSeriesValues('String', $parameter->name . '!$A$2:$A$' . $parameter_count + 1, null, $parameter_count)];
            $values     = [new DataSeriesValues('Number', $parameter->name . '!$B$2:$B$' . $parameter_count + 1, null, $parameter_count, [], 'none')];
            // $label      = [new DataSeriesValues('String', 'Worksheet!$B$1', null, 1)];
            // $categories = [new DataSeriesValues('String', 'Worksheet!$A$2:$A$' . $parameter_count + 1, null, $parameter_count)];
            // $values     = [new DataSeriesValues('Number', 'Worksheet!$B$2:$B$' . $parameter_count + 1, null, $parameter_count, [], 'none')];

            $series = new DataSeries(
                DataSeries::TYPE_LINECHART,
                DataSeries::GROUPING_STANDARD,
                range(0, count($values) - 1),
                $label,
                $categories,
                $values,
                null,
                null,
                DataSeries::STYLE_LINEMARKER
            );
            $plot   = new PlotArea(null, [$series]);

            $legend = new Legend();
            $chart  = new ChartChart($parameter->name . ' Chart', new Title($parameter->name . ' Chart'), $legend, $plot);
            // $chart->setTopLeftPosition('D' . (2 + (30 * $i)));
            // $chart->setBottomRightPosition('W' . (30 + (30 * $i)));
            $chart->setTopLeftPosition('D2');
            $chart->setBottomRightPosition('W30');
            $i++;
            return $chart;
            array_push($charts, $chart);
        }

        return $charts;
    }

    private function populateSheet($sheet, $parameter)
    {

        // $parameter = Parameters::find($this->parameter['parameter_id']);
        // $parameter = Parameters::find(1);
        $parameter_log = DB::table('parameter_log_' . $parameter->id)
            ->select('created_at', 'log_value')
            // ->where([
            //     ['created_at', '>=', $this->parameter['from']],
            //     ['created_at', '<=', $this->parameter['to']],
            // ])
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($this->parameter);
        // $sheet->getColumnDimension('A')->setWidth(200);
        // $sheet->getRowDimension('1')->setRowHeight(50);

        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Populate the static cells
        // $sheet->mergeCells('A1:B2');
        // $sheet->mergeCells('R1:Q2');
        // $sheet->mergeCells('C1:P1');

        $sheet->setCellValue('A1', "Created At");
        $sheet->setCellValue('B1', "Log Value");
        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        //query


        // $parameters_log = new Issue_log();
        // $parameters_log = $parameters_log->where([
        //     ['tgl_issue', '>=', $this->parameter['from']],
        //     ['tgl_issue', '<=', $this->parameter['to']],
        //     ['vehicle_id', '=', $this->parameter['vehicle_id']]
        // ])->latest()->get();

        $numrow = 2;
        $num_service = 1;
        foreach ($parameter_log as $row) {
            $sheet->setCellValue('A' . $numrow, $row->created_at);
            $sheet->setCellValue('B' . $numrow, $row->log_value);
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $numrow++;
            $num_service++;
        };
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
    }
    private function populateSheet2($sheet, $parameter)
    {

        // $parameter = Parameters::find($this->parameter['parameter_id']);
        // $parameter = Parameters::find(1);
        $parameter_log = DB::table('parameter_alert_' . $parameter->id)
            ->select('created_at', 'alert')
            // ->where([
            //     ['created_at', '>=', $this->parameter['from']],
            //     ['created_at', '<=', $this->parameter['to']],
            // ])
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($this->parameter);
        // $sheet->getColumnDimension('A')->setWidth(200);
        // $sheet->getRowDimension('1')->setRowHeight(50);

        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Populate the static cells
        // $sheet->mergeCells('A1:B2');
        // $sheet->mergeCells('R1:Q2');
        // $sheet->mergeCells('C1:P1');

        $sheet->setCellValue('D1', "Created At");
        $sheet->setCellValue('E1', "Alert");
        $sheet->getStyle('D1')->applyFromArray($style_col);
        $sheet->getStyle('E1')->applyFromArray($style_col);
        //query


        // $parameters_log = new Issue_log();
        // $parameters_log = $parameters_log->where([
        //     ['tgl_issue', '>=', $this->parameter['from']],
        //     ['tgl_issue', '<=', $this->parameter['to']],
        //     ['vehicle_id', '=', $this->parameter['vehicle_id']]
        // ])->latest()->get();

        $numrow = 2;
        $num_service = 1;
        foreach ($parameter_log as $row) {
            $sheet->setCellValue('D' . $numrow, $row->created_at);
            $sheet->setCellValue('E' . $numrow, $row->alert);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $numrow++;
            $num_service++;
        };
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
    }
}
