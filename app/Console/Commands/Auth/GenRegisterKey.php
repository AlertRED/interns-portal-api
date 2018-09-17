<?php
/**
 * Created by PhpStorm.
 * User: mxss
 * Date: 17.09.18
 * Time: 11:36
 */

namespace App\Console\Commands\Auth;

use Illuminate\Console\Command;

/**
 * Class GenRegisterKey
 * @package App\Console\Commands\Auth
 */
class GenRegisterKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:gen_register_key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ключа для регистрации вручную';

    public function handle() {
        $linkPrefix = "/register?";
        $this->info("ok");
    }
}