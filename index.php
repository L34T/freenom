<?php
/**
 * 入口文件
 *
 * 腾讯云函数版本维护：
 * 1、去掉顶部的 “#!/usr/bin/env php”，将文件名改为 index.php
 * 2、将 “define('IS_SCF', false);” 改为 “define('IS_SCF', true);”
 * 3、使用 function main_handler($event, $context) {} 将下面的 try catch 部分包起来，
 *    并在 try 最后一行追加 “return '云函数执行成功。';”，在 main_handler 函数的最后一行追加 “return '云函数执行失败。';”
 *
 * @author mybsdc <mybsdc@gmail.com>
 * @date 2019/3/2
 * @time 11:05
 * @link https://github.com/luolongfei/freenom
 */

error_reporting(E_ERROR);
ini_set('display_errors', 1);
set_time_limit(0);

define('IS_SCF', true); // 是否腾讯云函数环境
define('IS_CLI', PHP_SAPI === 'cli');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath(__DIR__));
define('VENDOR_PATH', realpath(ROOT_PATH . '/vendor'));
define('APP_PATH', realpath(ROOT_PATH . '/app'));
define('DATA_PATH', IS_SCF ? '/tmp' : realpath(ROOT_PATH . '/app/Data')); // 腾讯云函数只有 /tmp 目录的读写权限
define('RESOURCES_PATH', realpath(ROOT_PATH . '/resources'));

date_default_timezone_set('Asia/Shanghai');

/**
 * 注册错误处理
 */
register_shutdown_function('customize_error_handler');

/**
 * 注册异常处理
 */
set_exception_handler('exception_handler');

require VENDOR_PATH . '/autoload.php';

use Luolongfei\Libs\Log;
use Luolongfei\Libs\Message;

/**
 * @throws Exception
 */
function customize_error_handler()
{
    if (!is_null($error = error_get_last())) {
        Log::error('The program terminates unexpectedly', $error);
        Message::send('Error information：' . json_encode($error, JSON_UNESCAPED_UNICODE), 'Freenom: program terminated unexpectedly');
    }
}

/**
 * @param \Exception $e
 *
 * @throws \Exception
 */
function exception_handler($e)
{
    Log::error('Uncaught exception：' . $e->getMessage());
    Message::send("Exception content：\n" . $e->getMessage(), 'Freenom: uncaught exception');
}

function main_handler($event, $context)
{
    try {
        system_check();

        $class = sprintf('Luolongfei\App\Console\%s', get_argv('c', 'FreeNom'));
        $fn = get_argv('m', 'handle');

        $class::getInstance()->$fn();

        return 'Cloud function executed successfully.';
    } catch (\Exception $e) {
        system_log(sprintf('Execution error：<red>%s</red>', $e->getMessage()), $e->getTrace());
        Message::send("Execution error：\n" . $e->getMessage(), 'Freenom: catch exception');
    }

    return 'The execution of the cloud function failed.';
}
