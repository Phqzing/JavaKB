<?php

namespace Phqzing\JavaKB;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public static $instance;
    public $hasMoreKB = [];
    public $takeMoreKB = [];

    public function onEnable():void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new EListener(), $this);
    }

    public static function getInstance():Loader
    {
        return self::$instance;
    }
}