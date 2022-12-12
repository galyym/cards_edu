<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Mpdf;
use App\Http\Controllers\Card\PdfController;

class PdfFullCards implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $cards;
    protected $count;
    protected $id;
    protected $status;


    public function __construct($cards, $count, $id, $status)
    {
        $this->cards = $cards;
        $this->count = $count;
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = $this->count;
        $cards = $this->cards;
        $id = $this->id;
        $status = $this->status;
        $pdfController = new PdfController();

        $mpdf = new Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [54, 86],
            'margin_top' => 15,
            'margin_left' => 0,
            'margin_right' => 0,
            'mirrorMargins' => false
        ]);

        for ($i = 0; $i < count($cards); $i++) {

//            $checkDuplicate = $pdfController->checkDuplicate($cards[$i]->iinS);

//            if (!empty($checkDuplicate)){
//                DB::table('cards_ready')->insert([
//                    'full_name' => $cards[$i]->surname.' '.$cards[$i]->name,
//                    'iin' => $cards[$i]->iinS,
//                    'user_id' => $cards[$i]->id,
//                    'card_number' =>  $checkDuplicate->card_number."".$id,
//                    'status' => $status,
//                    'mektep_id' => $id
//                ]);
//            } else {
                $mpdf->AddPage();
                $code = $cards[$i]->iin;
                $nomer_code = $count;
                $html = '
                    <link rel="stylesheet" href="/public/css/w3.css">
                    <div style="text-align: center">
                        <barcode code="' . $code . '" type="QR" class="barcode" size="1" error="M" disableborder="1" />
                        <div style="text-align: left; margin-left: 55px;font-family: Segoe UI, Arial, sans-serif;">
                            <div style="margin-top: 60px;">
                                <p style="font-size: 10px; text-transform:uppercase; margin: 0; padding: 0;">' . $cards[$i]->name . ' ' . $cards[$i]->surname . '</p>
                                <p style="font-size: 10px; margin: 0; padding: 0;">NFC/RFID/QR/CODE128</p>
                            </div>
                        </div>
                    </div>
                    ';

                $mpdf->defaultfooterline = 0;
                $footer = '
                    <div style="position: absolute; margin-bottom: 10px; right: 26px; bottom: -10px; font-family: Segoe UI, Arial, sans-serif;">
                        <p style="font-size: 8px; margin-left: 10px;">' . $nomer_code . '</p>
                        <barcode code="' . $nomer_code . '" type="C128A" class="barcode" size="0.7" error="M" disableborder="1"/>
                    </div>';

                $mpdf->WriteHTML($html);
                $mpdf->SetHTMLFooter($footer);

                DB::table('cards_ready')->insert([
                    'full_name' => $cards[$i]->surname . ' ' . $cards[$i]->name,
                    'iin' => $cards[$i]->iinS,
                    'user_id' => $cards[$i]->id,
                    'card_number' => $nomer_code,
                    'status' => $status,
                    'mektep_id' => $id
                ]);

                $count++;
//            }
        }

        if(!file_exists(public_path('PDF/Cards/mektepN'.$id.'/'.$status))){
            mkdir(public_path('PDF/Cards/mektepN'.$id.'/'.$status), 0755, true);
        }

        $mpdf->Output(public_path('PDF/Cards/mektepN'.$id.'/'.$status.'/'.($count-count($cards)).'-'.$count.'.pdf'), 'F');
    }
}
