<?php

namespace Phqzing\JavaKB;

use pocketmine\player\Player;
use pocketmine\event\Listener;

use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\event\player\{PlayerCreationEvent, PlayerMoveEvent, PlayerQuitEvent};

class EListener implements Listener {

    public function onQuit(PlayerQuitEvent $ev):void
    {
        $player = $ev->getPlayer();
        if(isset(Loader::getInstance()->hasMoreKB[$player->getName()]))
            unset(Loader::getInstance()->hasMoreKB[$player->getName()]);
        if(isset(Loader::getInstance()->takeMoreKB[$player->getName()]))
            unset(Loader::getInstance()->takeMoreKB[$player->getName()]);
    }

    public function onPlayerCreation(PlayerCreationEvent $ev):void
    {
        $ev->setPlayerClass(JPlayer::class);
    }

    public function onDamage(EntityDamageEvent $ev):void
    {
        $v = $ev->getEntity();

        if(!($v instanceof Player)) return;

        $ev->setAttackCooldown(9.985);

        if(!($ev instanceof EntityDamageByEntityEvent)) return;
        if($ev->isCancelled()) return;

        $d = $ev->getDamager();

        if(isset(Loader::getInstance()->hasMoreKB[$d->getName()]) and Loader::getInstance()->hasMoreKB[$d->getName()] == true)
            Loader::getInstance()->takeMoreKB[$v->getName()] = $d;
    }

    public function onMove(PlayerMoveEvent $ev):void
    {
        $player = $ev->getPlayer();
        if($player->isSprinting())
        {
            if(!isset(Loader::getInstance()->hasMoreKB[$player->getName()]))
                Loader::getInstance()->hasMoreKB[$player->getName()] = true;
        }else{
            if(isset(Loader::getInstance()->hasMoreKB[$player->getName()]))
                unset(Loader::getInstance()->hasMoreKB[$player->getName()]);
        }
    }
}