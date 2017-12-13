<?php

namespace CrateUI\Commands;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;

use CrateUI\Main;

class getkeyui extends PluginCommand{

    public function __construct($name, Main $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Open Key UI");
        $this->setAliases(["keyui"]);
        $this->setPermission("crate.key");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if($sender instanceof Player){
          if($sender->hasPermission("crate.key")){
            $form = $this->getPlugin()->createCustomForm(function(Player $sender, array $data){
              $result = $data[0];
              if($result != null){
                $keycmd = "key ".$result." ".$data[1];
                $this->getPlugin()->getServer()->getCommandMap()->dispatch($sender->getPlayer(), $keycmd);
              }
            });
            $form->setTitle("§l§aCrates §eKey §fUI");
            $form->addInput("§bCrate");
            $form->addInput("§bUser");
            $form->sendToPlayer($sender);
          }
        }else{
          $sender->sendMessage("§cYou are not In-Game.");
        }
    return true;
  }
}
