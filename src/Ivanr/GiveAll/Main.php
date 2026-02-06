<?php

declare(strict_types=1);

namespace Ivanr\GiveAll;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\StringToItemParser;
use pocketmine\plugin\PluginBase;

final class Main extends PluginBase{

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() !== "giveall"){
            return false;
        }

        if(!isset($args[0])){
            $sender->sendMessage("§cUso: /giveall <item> [cantidad]");
            return true;
        }

        $itemString = strtolower($args[0]);
        $item = StringToItemParser::getInstance()->parse($itemString);

        if($item === null){
            $sender->sendMessage("§cItem inválido: §f{$args[0]}");
            return true;
        }

        $amount = 1;
        if(isset($args[1])){
            if(!is_numeric($args[1]) || (int) $args[1] < 1){
                $sender->sendMessage("§cLa cantidad debe ser un número mayor a 0.");
                return true;
            }

            $amount = min(64, (int) $args[1]);
        }

        $item->setCount($amount);

        $players = $this->getServer()->getOnlinePlayers();
        if(count($players) === 0){
            $sender->sendMessage("§eNo hay jugadores conectados.");
            return true;
        }

        $delivered = 0;
        foreach($players as $player){
            $leftover = $player->getInventory()->addItem(clone $item);
            if(count($leftover) > 0){
                foreach($leftover as $overflowItem){
                    $player->getWorld()->dropItem($player->getPosition(), $overflowItem);
                }
            }
            ++$delivered;
        }

        $sender->sendMessage("§aSe entregó §f{$item->getCount()}x {$item->getName()} §aa §f{$delivered} §ajugador(es).");
        return true;
    }
}
