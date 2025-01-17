<?php
/**
 * 命令行参数
 *
 * @author mybsdc <mybsdc@gmail.com>
 * @date 2020/1/3
 * @time 16:32
 */

namespace Luolongfei\Libs;

class Argv extends Base
{
    /**
     * @var array 所有命令行参数
     */
    public $allArgs = [];

    protected function init()
    {
        $this->parseAllArgs();

        if ($this->get('help') || $this->get('h')) {
            $desc = <<<FLL
Description
Params:
-c: <string> class to be called('FreeNom' class by default)
-m: <string> method to be called(static not supported. 'handle' method by default)
-h: show description

Example: 
$ php run -c=FreeNom -m=handle

FLL;
            echo $desc;

            exit(0);
        }
    }

    /**
     * 获取命令行参数
     *
     * @param string $name
     * @param string $default
     *
     * @return mixed|string
     */
    public function get(string $name, string $default = '')
    {
        return $this->allArgs[$name] ?? $default;
    }

    /**
     * 解析所有命令行参数
     *
     * @return array
     */
    public function parseAllArgs()
    {
        global $argv;

        foreach ($argv as $a) { // Windows默认命令行无法正确传入使用引号括住的带空格参数，换个命令行终端就好，Linux不受影响
            if (preg_match('/^-{1,2}(?P<name>\w+)(?:=([\'"]|)(?P<val>[^\n\t\v\f\r\'"]+)\2)?$/i', $a, $m)) {
                $this->allArgs[$m['name']] = $m['val'] ?? true;
            }
        }

        return $this->allArgs;
    }
}