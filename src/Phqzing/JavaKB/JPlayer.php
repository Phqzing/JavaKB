<?php

namespace Phqzing\JavaKB;

use pocketmine\player\Player;
use pocketmine\entity\{Attribute, AttributeFactory};
use stdClass;

class JPlayer extends Player {

    public function getPlugin():Loader
    {
        return Loader::getInstance();
    }

    public function knockBack(float $x, float $z, float $force = 4, ?float $base = 0.4):void
    {
        if(isset($this->getPlugin()->takeMoreKB[$this->getName()]))
        {
            $xzKB = 0.540;
            $yKb = 0.39;
        }else{
		    $xzKB = 0.487;
            $yKb = 0.34;
        }

        $f = sqrt($x * $x + $z * $z);
        if ($f <= 0) 
        {
            return;
        }
        if (mt_rand() / mt_getrandmax() > AttributeFactory::getInstance()->mustGet(Attribute::KNOCKBACK_RESISTANCE)->getValue())
        {
            $f = 1 / $f;

            $motion = clone $this->motion;

            $motion->x /= 2;
            $motion->y /= 2;
            $motion->z /= 2;
            $motion->x += $x * $f * $xzKB;
            $motion->y += $yKb;
            $motion->z += $z * $f * $xzKB;

            if ($motion->y > $yKb)
            {
                $motion->y = $yKb;
            }

            $this->setMotion($motion);
            if(isset($this->getPlugin()->takeMoreKB[$this->getName()]))
            {
                $damager = $this->getPlugin()->takeMoreKB[$this->getName()];
            }else{
                $damager = null;
            }
            if($damager instanceof Player)
            {
                $this->getPlugin()->hasMoreKB[$damager->getName()] = false;
            }
            if(isset($this->getPlugin()->takeMoreKB[$this->getName()])) unset($this->getPlugin()->takeMoreKB[$this->getName()]);
        }
    }
}