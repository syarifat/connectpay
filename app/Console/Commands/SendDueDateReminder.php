<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendDueDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-due-date-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = \Carbon\Carbon::now('Asia/Jakarta');
        $customers = \App\Models\Customer::where('jatuh_tempo', $today->day)->get();

        foreach ($customers as $c) {
            $pesan = "Halo {$c->nama}, mengingatkan tagihan ConnectPay Anda hari ini jatuh tempo. Silahkan lakukan pembayaran tepat waktu agar layanan tidak terisolir. Terima kasih.";
            $this->sendWa($c->nomor_wa, $pesan);
        }
    }
}
