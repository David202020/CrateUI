<?php
declare(strict_types = 1);
namespace CrateUI\Commands;

use CrateUI\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

class getkey extends PluginCommand{

    public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Get an crate key");
        $this->setAliases(["key"]);
        $this->setPermission("crate.key");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{

        #$inv = $player->getInventory();
        $commonname = Item::get(131,1,1);
        $votename = Item::get(131,2,1);
        $rarename = Item::get(131,3,1);
        $mythicname = Item::get(131,4,1);
        $legendaryname = Item::get(131,5,1);
        $e = Enchantment::getEnchantment(0);

        if (count($args) < 1) {
            $sender->sendMessage("§b===>§eKeys§b<===");
            $sender->sendMessage("§a/getkey Common §e: §bGet Common key.");
            $sender->sendMessage("§c/getkey Vote §e: §bGet Vote key.");
            $sender->sendMessage("§6/getkey Rare §e: §bGet Rare key.");
            $sender->sendMessage("§5/getkey Mythic §e: §bGet Mythic key.");
            $sender->sendMessage("§b/getkey Legendary §e: §bGet Legendary key.");
            $sender->sendMessage("§b===>§eKeys§b<===");
            return false;
        }
        switch ($args[0]){
            case "1":
            case "common":
            case "Common":
                    if (!$sender->hasPermission("crate.key")) {
                        $sender->sendMessage("§cYou are not allow to do that.");
                        return false;
                    }
                    if (count($args) < 2) {
                        $sender->sendMessage("Usage: /key Common <Player>");
                        return false;
                    }
                    if (isset($args[1])) {
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    }
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    if (!$player instanceof Player) {
                        if ($player instanceof ConsoleCommandSender) {
                            $sender->sendMessage("§cPlease enter a player name.");
                            return false;
                        }
                        $sender->sendMessage("§cThat Player doesnt exit.");
                        return false;
                    }
            $e->setLevel(-1);
            $commonname->addEnchantment($e);
            $commonname->setCustomName("§aCommon");
            $player->getInventory()->addItem($commonname);
            $player->sendMessage("§eYou receive a §aCommon §eKey.");
            $sender->sendMessage("§9" . $player->getName() . " §ehas received a §aCommon §eKey.");
            break;
            case "2":
            case "vote":
            case "Vote":
                    if (!$sender->hasPermission("crate.key")) {
                        $sender->sendMessage("§cYou are not allow to do that.");
                        return false;
                    }
                    if (count($args) < 2) {
                        $sender->sendMessage("Usage: /key Vote <Player>");
                        return false;
                    }
                    if (isset($args[1])) {
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    }
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    if (!$player instanceof Player) {
                        if ($player instanceof ConsoleCommandSender) {
                            $sender->sendMessage("§cPlease enter a player name.");
                            return false;
                        }
                        $sender->sendMessage("§cThat Player doesnt exit.");
                        return false;
                    }
            $e->setLevel(-1);
            $votename->addEnchantment($e);
            $votename->setCustomName("§cVote");
            $player->getInventory()->addItem($votename);
            $player->sendMessage("§eYou receive a §cVote §eKey.");
            $sender->sendMessage("§9" . $player->getName() . " §ehas received a §cVote §eKey.");
            break;
            case "3":
            case "rare":
            case "Rare":
                    if (!$sender->hasPermission("crate.key")) {
                        $sender->sendMessage("§cYou are not allow to do that.");
                        return false;
                    }
                    if (count($args) < 2) {
                        $sender->sendMessage("Usage: /key Rare <Player>");
                        return false;
                    }
                    if (isset($args[1])) {
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    }
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    if (!$player instanceof Player) {
                        if ($player instanceof ConsoleCommandSender) {
                            $sender->sendMessage("§cPlease enter a player name.");
                            return false;
                        }
                        $sender->sendMessage("§cThat Player doesnt exit.");
                        return false;
                    }
            $e->setLevel(-1);
            $rarename->addEnchantment($e);
            $rarename->setCustomName("§6Rare");
            $player->getInventory()->addItem($rarename);
            $player->sendMessage("§eYou receive a §6Rare §eKey.");
            $sender->sendMessage("§9" . $player->getName() . " §ehas received a §6Rare §eKey.");
            break;
            case "4":
            case "mythic":
            case "Mythic":
                    if (!$sender->hasPermission("crate.key")) {
                        $sender->sendMessage("§cYou are not allow to do that.");
                        return false;
                    }
                    if (count($args) < 2) {
                        $sender->sendMessage("Usage: /key Mythic <Player>");
                        return false;
                    }
                    if (isset($args[1])) {
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    }
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    if (!$player instanceof Player) {
                        if ($player instanceof ConsoleCommandSender) {
                            $sender->sendMessage("§cPlease enter a player name.");
                            return false;
                        }
                        $sender->sendMessage("§cThat Player doesnt exit.");
                        return false;
                    }
            $e->setLevel(-1);
            $mythicname->addEnchantment($e);
            $mythicname->setCustomName("§5Mythic");
            $player->getInventory()->addItem($mythicname);
            $player->sendMessage("§eYou receive a §5Mythic §eKey.");
            $sender->sendMessage("§9" . $player->getName() . " §ehas received a §5Mythic §eKey.");
            break;
            case "5":
            case "legendary":
            case "Legendary":
                    if (!$sender->hasPermission("crate.key")) {
                        $sender->sendMessage("§cYou are not allow to do that.");
                        return false;
                    }
                    if (count($args) < 2) {
                        $sender->sendMessage("Usage: /key Legendary <Player>");
                        return false;
                    }
                    if (isset($args[1])) {
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    }
                        $player = $this->getPlugin()->getServer()->getPlayer($args[1]);
                    if (!$player instanceof Player) {
                        if ($player instanceof ConsoleCommandSender) {
                            $sender->sendMessage("§cPlease enter a player name.");
                            return false;
                        }
                        $sender->sendMessage("§cThat Player doesnt exit.");
                        return false;
                    }
            $e->setLevel(-1);
            $legendaryname->addEnchantment($e);
            $legendaryname->setCustomName("§9Legendary");
            $player->getInventory()->addItem($legendaryname);
            $player->sendMessage("§eYou receive a §9Legendary §eKey.");
            $sender->sendMessage("§9" . $player->getName() . " §ehas received a §9Legendary §eKey.");
            break;
            default:
            $sender->sendMessage("§b===>§eKeys§b<===");
            $sender->sendMessage("§a/getkey Common §e: §bGet Common key.");
            $sender->sendMessage("§c/getkey Vote §e: §bGet Vote key.");
            $sender->sendMessage("§6/getkey Rare §e: §bGet Rare key.");
            $sender->sendMessage("§5/getkey Mythic §e: §bGet Mythic key.");
            $sender->sendMessage("§b/getkey Legendary §e: §bGet Legendary key.");
            $sender->sendMessage("§b===>§eKeys§b<===");
            break;
            }
            return true;
        }
}
