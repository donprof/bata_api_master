<?php

namespace App\Http\Controllers\Reports\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\DatesRequest;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class R01Controller extends Controller
{
    private function generateQuery($request){

        $datefrom = (!empty($request->datefrom) ? Carbon::parse($request->datefrom)->format('Y-m-d') : null);
        $dateto = (!empty($request->dateto) ? Carbon::parse($request->dateto)->format('Y-m-d') : null);

        $data = DB::select("SELECT
            u.name AS 'name',
            u.email AS 'email',
            u.phone AS 'phone',
            o.created_at AS 'created_at',
            s.name as 'shipping',
            s.price as 'price',
            o.status as 'orderstatus',
            o.order_number AS 'ordernumber',
            o.subtotal AS 'subtotal',
            p.card_type AS 'paymenttype'
            FROM orders AS o
            LEFT JOIN users AS u ON o.user_id = u.id
            LEFT JOIN shipping_methods AS s ON o.shipping_method_id = s.id
            LEFT JOIN payment_methods AS p ON o.payment_method_id = p.id
            WHERE DATE_FORMAT(o.created_at, '%Y-%m-%d')  BETWEEN '$datefrom' AND '$dateto'");
        
            return $data;
    }

    public function r01pdf(DatesRequest $request)
    {
        $pdf = new Fpdf;
        $datefrom = (!empty($request->datefrom) ? Carbon::parse($request->datefrom)->format('Y-m-d') : null);
        $dateto = (!empty($request->dateto) ? Carbon::parse($request->dateto)->format('Y-m-d') : null);
        $data = $this->generateQuery($request);

        $pdf->AddPage('L');
        $pdf->Ln(10);
        $pdf->Image(public_path('images/').config('app.applogo'),240,15,40);
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(173,-15,'', 0,2,'R');
        $pdf->Cell(1,5,'',0,2,'L');
        $pdf->Cell(1,3,'Bata kenya',0,2,'L');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(1,5,'',0,2,'L');
        $pdf->Cell(1,5,$request->reporttitle,0,2,'L');
        $pdf->Cell(1,5,'Period from '.Carbon::parse($request->datefrom)->format('d F Y').' to '.Carbon::parse($request->dateto)->format('d F Y'),0,2,'L');
        $pdf->Cell(1,5,'Generated on '.Carbon::now()->format('d F Y'), 0,2,'L');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(173,5,'', 0,2,'R');
        $pdf->Cell(170,5,'', 0,1,'R');

        $pdf->SetFont('Arial','B',10);
        $pdf->setFillColor(0,184,200);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(55,5,'Name','TBRL',0,'L',1);
        $pdf->Cell(35,5,'Phone','TBRL',0,'L',1);
        $pdf->Cell(30,5,'Shipping','TBRL',0,'L',1);
        $pdf->Cell(25,5,'Status','TBRL',0,'L',1);
        $pdf->Cell(30,5,'Order Number','TBRL',0,'L',1);
        $pdf->Cell(25,5,'Subtotal','TBRL',0,'L',1);
        $pdf->Cell(30,5,'Shipping cost','TBRL',0,'L',1);
        $pdf->Cell(40,5,'Payment type','TBRL',0,'L',1);
        $pdf->Cell(20,5,'',2,1,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->setFillColor(255,255,255);
        $pdf->SetFont('Arial','',8);

        $totallitterscalc = 0;
        $totalcostclac = 0;
        foreach ($data as $obj) {
            $name = $obj->name;
            $email = $obj->email;
            $phone = $obj->phone;
            $created_at = $obj->created_at;
            $shipping = $obj->shipping;
            $price = $obj->price;
            $orderstatus = $obj->orderstatus;
            $ordernumber = $obj->ordernumber;
            $subtotal = $obj->subtotal;
            $paymenttype = $obj->paymenttype;

            $pdf->Cell(55,5,$name,'TBRL',0,'L',1);
            $pdf->Cell(35,5,$phone,'TBRL',0,'L',1);
            $pdf->Cell(30,5,$shipping,'TBRL',0,'L',1);
            $pdf->Cell(25,5,$orderstatus,'TBRL',0,'L',1);
            $pdf->Cell(30,5,$ordernumber,'TBRL',0,'L',1);
            $pdf->Cell(25,5,$subtotal,'TBRL',0,'L',1);
            $pdf->Cell(30,5,$price,'TBRL',0,'L',1);
            $pdf->Cell(40,5,$paymenttype,'TBRL',0,'L',1);
            // $pdf->Cell(20,5,'',2,1,'L');
            // $pdf->SetTextColor(0,0,0);
            // $pdf->SetFont('Arial','',8);

            $pdf->Ln(5);

        }
        $pdf->Output();
    }

    public function r01xlsx(DatesRequest $request)
    {
        $datefrom = (!empty($request->datefrom) ? Carbon::parse($request->datefrom)->format('Y-m-d') : null);
        $dateto = (!empty($request->dateto) ? Carbon::parse($request->dateto)->format('Y-m-d') : null);
        $data = $this->generateQuery($request);

        Excel::create('Filename', function($excel) use($request, $data, $datefrom, $dateto) {
            $excel->sheet('Daily Fuel Issue Report', function($sheet) use($request, $data, $datefrom, $dateto) {
                $vehicleArray[] = ['Bata kenya'];
                $vehicleArray[] = [$request->reporttitle];
                $vehicleArray[] = ['Period from '.Carbon::parse($datefrom)->format('d F Y').' to '.Carbon::parse($datefrom)->format('d F Y')];
                $vehicleArray[] = ['Generated on: '.Carbon::now()->format('d F Y')];
                $vehicleArray[] = [''];
                $vehicleArray[] = ['Name','Phone','Shipping','Status','Order Number','Subtotal','Shipping cost','Payment type'];

                $totallitterscalc = 0;
                $totalcostclac = 0;

                foreach ($data as $obj) {
                    $name = $obj->name;
                    $email = $obj->email;
                    $phone = $obj->phone;
                    $created_at = $obj->created_at;
                    $shipping = $obj->shipping;
                    $price = $obj->price;
                    $orderstatus = $obj->orderstatus;
                    $ordernumber = $obj->ordernumber;
                    $subtotal = $obj->subtotal;
                    $paymenttype = $obj->paymenttype;

                    $vehicleArray[] = [$name,$phone,$shipping,$orderstatus,$ordernumber,$subtotal,$price,$paymenttype];
                }
                // $vehicleArray[] = ['Grand Total',number_format($totallitterscalc, 2),number_format($totalcostclac, 2)];
                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');
                $sheet->mergeCells('A3:C3');
                $sheet->mergeCells('A4:C4');
                $sheet->mergeCells('A5:C5');
                $sheet->cells('A1:A5', function($cells) {
                    $cells->setFontColor('#FF0000');
                });
                $sheet->cells('A7:H7', function($cells) {
                    $cells->setFontColor('#FFFFFF');
                    $cells->setFontWeight('bold');
                    $cells->setBackground('#00B8C8');
                });
                $sheet->fromArray($vehicleArray);
            });
        })->export('xlsx');
    }
}
