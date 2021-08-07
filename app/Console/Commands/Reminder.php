<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Todo;

use Illuminate\Support\Facades\Mail;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('start');
        $reminds = Todo::where('send_at', Carbon::now()->format('Y-m-d H:i'))->get();
        foreach($reminds as $remind){
            // プレーンテキスト(ここではToDoテーブルのcontentカラムないデータのみ)を送る場合はMail::row
            // ↑第一引数に指定
            // viewの内容をメール本文に反映させるにはMail::send
            // ▼参考
            // バッチ処理:
            // 1. http://tech.innovation.co.jp/2017/04/03/laravel-reminder.html
            // 2. https://reffect.co.jp/laravel/laravel-task-schedule-cron
            // nanoエディタ：http://ftp.lumica.co.jp/_nano/close_nano.html
            Mail::raw(Carbon::now()->format('m/d H時i分')."です。".$remind->content."をしてください", function ($message) use($remind) {
                $message->to($remind->user->email)->subject('リマインド');
            });
        }
        $this->info(Carbon::now()->format('Y-m-d H:m:00'));
        $this->info('Complete');
    }
}
