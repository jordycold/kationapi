<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;

class DisableUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disable:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deshabilitar usuarios que no se hayan autenticado en los últimos 10 días.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $user = User::all();
        foreach($user as $us){
        $last1 = date('Y-m-d', strtotime($us->last_login));
        $now = now();
        $days = Carbon::parse($last1)->diffInDays(Carbon::parse($now));

            if($days >= 10){
                $last_login = array("deleted_at" => now());
                \DB::table('users')->where('id', $us->id)->update($last_login);
            }
        }
    }
}
