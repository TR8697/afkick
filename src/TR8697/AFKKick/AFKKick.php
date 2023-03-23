<?php

namespace TR8697\AFKKick;

use TR8697\AFKKick\tasks\KickTask;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;

class AFKKick extends PluginBase implements Listener {

    public $afkTime = [];

    public const maxAFKTime = "PT1M";

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getScheduler()->scheduleRepeatingTask(new KickTask($this), 20);
    }


    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $now = new \DateTime("now", new \DateTimeZone("Europe/İstanbul"));
        $now->add(new \DateInterval(self::maxAFKTime));
        $this->afkTime[$player->getName()] = $now;
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        unset($this->afkTime[$player->getName()]);
    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $now = new \DateTime("now", new \DateTimeZone("Europe/İstanbul"));
        $now->add(new \DateInterval(self::maxAFKTime));
        $this->afkTime[$player->getName()] = $now;
    }
}
