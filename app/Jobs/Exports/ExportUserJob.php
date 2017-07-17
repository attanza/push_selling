<?php

namespace App\Jobs\Exports;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Excel;
use App\User;

class ExportUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->users;
        Excel::create('Users', function ($excel) use ($users) {
            $excel->sheet('Users', function ($sheet) use ($users) {
                $sheet->mergeCells('A1:G1');
                $sheet->loadView('exports.user')->with('users', $users);
            });
        })->download('xlsx');
    }
}
