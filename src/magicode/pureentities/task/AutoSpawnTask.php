<?php

namespace magicode\pureentities\task;

use magicode\pureentities\PureEntities;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;

class AutoSpawnTask extends PluginTask {

    public function __construct(PureEntities $plugin) {
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    
    public function onRun($currentTick){
        
        $entities = [];
        $valid = false;
        foreach($this->plugin->getServer()->getLevels() as $level) {
            foreach($level->getPlayers() as $player){
                foreach($level->getEntities() as $entity) {
                    if($player->distance($entity) <= 20) {
                        $valid = true;
                    }
                }
            
                $entities[] = $entity;
        
                if($valid && count($entities) <= 5) {
                    $x = $player->x + mt_rand(-20, 20);
                    $z = $player->z + mt_rand(-20, 20);
                    $pos = new Position(
                        $x,
                        ($y = $level->getHighestBlockAt($x, $z) + 1),
                        $z,
                        $level
                    );
                }
            
                switch(mt_rand(1, 5)) {
                    case 1:
                        $type = 32;
                        break;
                    case 2:
                        $type = 34;
                        break;
                    case 3:
                        $type = 35;
                        break;
                    case 4:
                        $type = 38;
                        break;
                    case 5:
                        $type = 44;
                        break;
                }
            
                $time = $level->getTime() % Level::TIME_FULL;
                
                if(
                    !$player->distance($pos) <= 8 &&
                    $time >= 10900 && $time < 17800
                ) {
                    $entity = PureEntities::create($type, $pos);
                    $entity->spawnToAll();
                } else {
                    switch(mt_rand(1, 4)) {
                    case 1:
                        $entype = 11;
                        break;
                    case 2:
                        $entype = 12;
                        break;
                    case 3:
                        $entype = 10;
                        break;
                    case 4:
                        $entype = 13;
                        break;
                    }                   
                    $entity = PureEntities::create($entype, $pos);
                    $entity->spawnToAll();      
                }
            }
        }
    }
}
