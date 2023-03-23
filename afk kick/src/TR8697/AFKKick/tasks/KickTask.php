<?php

namespace TR8697\AFKKick\tasks;

use TR8697\AFKKick\AFKKick;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class KickTask extends Task {

    private $main;

    public function __construct(AFKKick $main){
        $this->main = $main;
    }

    public function onRun(): void{
        foreach ($this->main->afkTime as $playername => $time){
            $player = Server::getInstance()->getPlayerExact($playername);
            if($player){
                $now = new \DateTime("now", new \DateTimeZone("Europe/İstanbul"));
                if ($time < $now){
                    $player->kick("Çok uzun zamandır AFK'DAYDIN!");
                }
            }
        }
    }
}