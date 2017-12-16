<?php

namespace CrateUI;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\level\Level;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\sound\EndermanTeleportSound;

use pocketmine\math\Vector3;

use pocketmine\inventory\Inventory;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;

use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

use CrateUI\Commands\getkey;
use CrateUI\Commands\getkeyui;

class Main extends PluginBase implements Listener{

	public $formCount = 0;

	public $forms = [];

	private static $instance;

	public static function getInstance(): Main{
		return self::$instance;
	}

	public function onEnable(){
		self::$instance = $this;
		$this->saveDefaultConfig();
		$this->cfg = $this->getConfig();
	 	$this->getServer()->getPluginManager()->registerEvents($this, $this);
	 	$this->getServer()->getCommandMap()->register("getkey", new getkey("getkey", $this));
	        $this->getServer()->getCommandMap()->register("getkeyui", new getkeyui("getkeyui", $this));
		$this->getLogger()->info("§aEnabled.");
	}

	public function onDisable(){
	    $this->getLogger()->info("§cDisabled.");
	}

	public function createCustomForm(callable $function = null) : CustomForm {
		$this->formCount++;
		$form = new CustomForm($this->formCount, $function);
		if($function !== null){
			$this->forms[$this->formCount] = $form;
		}
		return $form;
	}

	public function createSimpleForm(callable $function = null) : SimpleForm {
		$this->formCount++;
		$form = new SimpleForm($this->formCount, $function);
		if($function !== null){
			$this->forms[$this->formCount] = $form;
		}
		return $form;
	}

	public function onPacketReceived(DataPacketReceiveEvent $ev) : void {
		$pk = $ev->getPacket();
		if($pk instanceof ModalFormResponsePacket){
			$player = $ev->getPlayer();
			$formId = $pk->formId;
			$data = json_decode($pk->formData, true);
			if(isset($this->forms[$formId])){
				/** @var Form $form */
				$form = $this->forms[$formId];
				if(!$form->isRecipient($player)){
					return;
				}
				$callable = $form->getCallable();
				if(!is_array($data)){
					$data = [$data];
				}
				if($callable !== null) {
					$callable($ev->getPlayer(), $data);
				}
				unset($this->forms[$formId]);
				$ev->setCancelled();
			}
		}
	}

	public function onPlayerQuit(PlayerQuitEvent $ev){
		$player = $ev->getPlayer();
		/**
		 * @var int $id
		 * @var Form $form
		 */
		foreach($this->forms as $id => $form){
			if($form->isRecipient($player)){
				unset($this->forms[$id]);
				break;
			}
		}
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
	     if($cmd->getName() == "crate"){
			 if($sender instanceof Player){
				$form = $this->createSimpleForm(function (Player $sender, array $data) {
					$result = $data[0];
					if ($result === null) {
					}
					switch ($result) {
						case 1:
							//common
							$inv = $sender->getInventory();
							if($inv->contains(Item::get(131,1,1))){
								$level = $sender->getLevel();
								$x = $sender->getX();
								$y = $sender->getY();
								$z = $sender->getZ();
								$pos = new Vector3($x, $y + 2, $z);
								$pos1 = new Vector3($x, $y, $z);
								$name = $sender->getName();
								$prefix = $this->cfg->get("Prefix");

							//Item1

								$CommonItem1 = ItemFactory::fromString($this->cfg->getNested("Common.1.Item"));
								$CommonAmount1 = $this->cfg->getNested("Common.1.Amount");
								$CommonBroadcast1 = $this->cfg->getNested("Common.1.Broadcast");

							//Item 2

								$CommonItem2 = ItemFactory::fromString($this->cfg->getNested("Common.2.Item"));
								$CommonAmount2 = $this->cfg->getNested("Common.2.Amount");
								$CommonBroadcast2 = $this->cfg->getNested("Common.2.Broadcast");

							//Item 3

								$CommonItem3 = ItemFactory::fromString($this->cfg->getNested("Common.3.Item"));
								$CommonAmount3 = $this->cfg->getNested("Common.3.Amount");
								$CommonBroadcast3 = $this->cfg->getNested("Common.3.Broadcast");

								$level->addSound(new EndermanTeleportSound($pos1));
								$level->addParticle(new LavaParticle($pos1));
								$inv->removeItem(Item::get(131,1,1));
								$sender->addTitle("§eOpening Crate:", "§aCommon!");
								$this->getServer()->broadcastMessage($prefix . " §b$name §ajust opened Common Crate!");
								$result = rand(1,3);
									 switch($result){
							case 1:
								$inv->addItem($CommonItem1->setCount($CommonAmount1));
								$sender->sendMessage($prefix . $CommonBroadcast1);
								 break;
							case 2:
								$inv->addItem($CommonItem2->setCount($CommonAmount2));
								$sender->sendMessage($prefix . $CommonBroadcast2);
								 break;
							case 3:
								$inv->addItem($CommonItem3->setCount($CommonAmount3));
								$sender->sendMessage($prefix . $CommonBroadcast3);
								 break;
									 }
							}else{
								$prefix = $this->cfg->get("Prefix");
								$sender->sendMessage($prefix . " §fYou don't have §aCommon §fKey.");
							}
							break;
						case 2:
							//vote
							$inv = $sender->getInventory();
							if($inv->contains(Item::get(131,2,1))){
								$level = $sender->getLevel();
								$x = $sender->getX();
								$y = $sender->getY();
								$z = $sender->getZ();
								$pos = new Vector3($x, $y + 2, $z);
								$pos1 = new Vector3($x, $y, $z);
								$name = $sender->getName();
								$prefix = $this->cfg->get("Prefix");

							//Item1

								$VoteItem1 = ItemFactory::fromString($this->cfg->getNested("Vote.1.Item"));
								$VoteAmount1 = $this->cfg->getNested("Vote.1.Amount");
								$VoteBroadcast1 = $this->cfg->getNested("Vote.1.Broadcast");

							//Item 2

								$VoteItem2 = ItemFactory::fromString($this->cfg->getNested("Vote.2.Item"));
								$VoteAmount2 = $this->cfg->getNested("Vote.2.Amount");
								$VoteBroadcast2 = $this->cfg->getNested("Vote.2.Broadcast");

							//Item 3

								$VoteItem3 = ItemFactory::fromString($this->cfg->getNested("Vote.3.Item"));
								$VoteAmount3 = $this->cfg->getNested("Vote.3.Amount");
								$VoteBroadcast3 = $this->cfg->getNested("Vote.3.Broadcast");

							//Item 4

								$VoteItem4 = ItemFactory::fromString($this->cfg->getNested("Vote.4.Item"));
								$VoteAmount4 = $this->cfg->getNested("Vote.4.Amount");
								$VoteBroadcast4 = $this->cfg->getNested("Vote.4.Broadcast");

							//Item 5

								$VoteItem5 = ItemFactory::fromString($this->cfg->getNested("Vote.5.Item"));
								$VoteAmount5 = $this->cfg->getNested("Vote.5.Amount");
								$VoteBroadcast5 = $this->cfg->getNested("Vote.5.Broadcast");

								$level->addSound(new EndermanTeleportSound($pos1));
								$level->addParticle(new LavaParticle($pos1));
								$inv->removeItem(Item::get(131,2,1));
								$sender->addTitle("§eOpening Crate:", "§cVote!");
								$this->getServer()->broadcastMessage($prefix . " §b$name §ajust opened §cVote §aCrate!");
								$result = rand(1,5);
									 switch($result){
							case 1:
								$inv->addItem($VoteItem1->setCount($VoteAmount1));
								$sender->sendMessage($prefix . $VoteBroadcast1);
								 break;
							case 2:
								$inv->addItem($VoteItem2->setCount($VoteAmount2));
								$sender->sendMessage($prefix . $VoteBroadcast2);
								 break;
							case 3:
								$inv->addItem($VoteItem3->setCount($VoteAmount3));
								$sender->sendMessage($prefix . $VoteBroadcast3);
								 break;
							case 4:
								$inv->addItem($VoteItem4->setCount($VoteAmount4));
								$sender->sendMessage($prefix . $VoteBroadcast4);
								 break;
							case 5:
								$inv->addItem($VoteItem5->setCount($VoteAmount5));
								$sender->sendMessage($prefix . $VoteBroadcast5);
								 break;
									 }
							}else{
								$prefix = $this->cfg->get("Prefix");
								$sender->sendMessage($prefix . " §fYou don't have §cVote §fKey.");
							}
						break;
						case 3:
							//rare
							$inv = $sender->getInventory();
							if($inv->contains(Item::get(131,3,1))){
								$level = $sender->getLevel();
								$x = $sender->getX();
								$y = $sender->getY();
								$z = $sender->getZ();
								$pos = new Vector3($x, $y + 2, $z);
								$pos1 = new Vector3($x, $y, $z);
								$name = $sender->getName();
								$prefix = $this->cfg->get("Prefix");

							//Item1

								$RareItem1 = ItemFactory::fromString($this->cfg->getNested("Rare.1.Item"));
								$RareAmount1 = $this->cfg->getNested("Rare.1.Amount");
								$RareBroadcast1 = $this->cfg->getNested("Rare.1.Broadcast");

							//Item 2

								$RareItem2 = ItemFactory::fromString($this->cfg->getNested("Rare.2.Item"));
								$RareAmount2 = $this->cfg->getNested("Rare.2.Amount");
								$RareBroadcast2 = $this->cfg->getNested("Rare.2.Broadcast");

							//Item 3

								$RareItem3 = ItemFactory::fromString($this->cfg->getNested("Rare.3.Item"));
								$RareAmount3 = $this->cfg->getNested("Rare.3.Amount");
								$RareBroadcast3 = $this->cfg->getNested("Rare.3.Broadcast");

							//Item 4

								$RareItem4 = ItemFactory::fromString($this->cfg->getNested("Rare.4.Item"));
								$RareAmount4 = $this->cfg->getNested("Rare.4.Amount");
								$RareBroadcast4 = $this->cfg->getNested("Rare.4.Broadcast");

							//Item 5

								$RareItem5 = ItemFactory::fromString($this->cfg->getNested("Rare.5.Item"));
								$RareAmount5 = $this->cfg->getNested("Rare.5.Amount");
								$RareBroadcast5 = $this->cfg->getNested("Rare.5.Broadcast");

								$level->addSound(new EndermanTeleportSound($pos1));
								$level->addParticle(new LavaParticle($pos1));
								$inv->removeItem(Item::get(131,2,1));
								$sender->addTitle("§eOpening Crate:", "§6Rare!");
								$this->getServer()->broadcastMessage($prefix . " §b$name §ajust opened §6Rare §aCrate!");
								$result = rand(1,5);
									 switch($result){
							case 1:
								$inv->addItem($RareItem1->setCount($RareAmount1));
								$sender->sendMessage($prefix . $RareBroadcast1);
								 break;
							case 2:
								$inv->addItem($RareItem2->setCount($RareAmount2));
								$sender->sendMessage($prefix . $RareBroadcast2);
								 break;
							case 3:
								$inv->addItem($RareItem3->setCount($RareAmount3));
								$sender->sendMessage($prefix . $RareBroadcast3);
								 break;
							case 4:
								$inv->addItem($RareItem4->setCount($RareAmount4));
								$sender->sendMessage($prefix . $RareBroadcast4);
								 break;
							case 5:
								$inv->addItem($RareItem5->setCount($RareAmount5));
								$sender->sendMessage($prefix . $RareBroadcast5);
								 break;
									 }
							}else{
								$prefix = $this->cfg->get("Prefix");
								$sender->sendMessage($prefix . " §fYou don't have §6Rare §fKey.");
							}
						break;
						case 4:
							//WitherBox
							$inv = $sender->getInventory();
							if($inv->contains(Item::get(131,4,1))){
								$level = $sender->getLevel();
								$x = $sender->getX();
								$y = $sender->getY();
								$z = $sender->getZ();
								$pos = new Vector3($x, $y + 2, $z);
								$pos1 = new Vector3($x, $y, $z);
								$name = $sender->getName();
								$prefix = $this->cfg->get("Prefix");

							//Item1

								$WitherBoxItem1 = ItemFactory::fromString($this->cfg->getNested("WitherBox.1.Item"));
								$WitherBoxAmount1 = $this->cfg->getNested("WitherBox.1.Amount");
								$WitherBoxBroadcast1 = $this->cfg->getNested("WitherBox.1.Broadcast");

							//Item2

								$WitherBoxItem2 = ItemFactory::fromString($this->cfg->getNested("WitherBox.2.Item"));
								$WitherBoxAmount2 = $this->cfg->getNested("WitherBox.2.Amount");
								$WitherBoxBroadcast2 = $this->cfg->getNested("WitherBox.2.Broadcast");

							//Item3

								$WitherBox3 = ItemFactory::fromString($this->cfg->getNested("WitherBox.3.Item"));
								$WitherBoxAmount3 = $this->cfg->getNested("WitherBox.3.Amount");
								$WitherBoxBroadcast3 = $this->cfg->getNested("WitherBox.3.Broadcast");

							//Item4

								$WitherBoxItem4 = ItemFactory::fromString($this->cfg->getNested("WitherBox.4.Item"));
								$WitherBoxAmount4 = $this->cfg->getNested("WitherBox.4.Amount");
								$WitherBoxBroadcast4 = $this->cfg->getNested("WitherBox.4.Broadcast");

							//Item5

								$WitherBoxItem5 = ItemFactory::fromString($this->cfg->getNested("WitherBox.5.Item"));
								$WitherBoxAmount5 = $this->cfg->getNested("WitherBox.5.Amount");
								$WitherBoxBroadcast5 = $this->cfg->getNested("WitherBox.5.Broadcast");

							//Item6

								$WitherBoxItem6 = ItemFactory::fromString($this->cfg->getNested("WitherBox.6.Item"));
								$WitherBoxAmount6 = $this->cfg->getNested("WitherBox.6.Amount");
								$WitherBoxBroadcast6 = $this->cfg->getNested("WitherBox.6.Broadcast");

							//Item7

								$WitherBoxItem7 = ItemFactory::fromString($this->cfg->getNested("WitherBox.7.Item"));
								$WitherBoxAmount7 = $this->cfg->getNested("WitherBox.7.Amount");
								$WitherBoxBroadcast7 = $this->cfg->getNested("WitherBox.7.Broadcast");

							//Item8

								$WitherBoxItem8 = ItemFactory::fromString($this->cfg->getNested("WitherBox.8.Item"));
								$WitherBoxAmount8 = $this->cfg->getNested("WitherBox.8.Amount");
								$WitherBoxBroadcast8 = $this->cfg->getNested("WitherBox.8.Broadcast");

								$level->addSound(new EndermanTeleportSound($pos1));
								$level->addParticle(new LavaParticle($pos1));
								$inv->removeItem(Item::get(131,4,1));
								$sender->addTitle("§eOpening Crate:", "§WitherBox!");
								$this->getServer()->broadcastMessage($prefix . " §b$name §ajust opened §cWither&fBox §aCrate!");
								$result = rand(1,8);
									 switch($result){
							case 1:
								$inv->addItem($WitherBoxItem1->setCount($WitherBoxAmount1));
								$sender->sendMessage($prefix . $WitherBoxBroadcast1);
								 break;
							case 2:
								$inv->addItem($WitherBoxItem2->setCount($WitherBoxAmount2));
								$sender->sendMessage($prefix . $WitherBoxBroadcast2);
								 break;
							case 3:
								$inv->addItem($WitherBoxItem3->setCount($WitherBoxAmount3));
								$sender->sendMessage($prefix . $WitherBoxBroadcast3);
								 break;
							case 4:
								$inv->addItem($WitherBoxItem4->setCount($WitherBoxAmount4));
								$sender->sendMessage($prefix . $WitherBoxBroadcast4);
								 break;
							case 5:
								$inv->addItem($WitherBoxItem5->setCount($WitherBoxAmount5));
								$sender->sendMessage($prefix . $WitherBoxBroadcast5);
								 break;
							case 6:
								$inv->addItem($WitherBoxItem6->setCount($WitherBoxAmount6));
								$sender->sendMessage($prefix . $WitherBoxBroadcast6);
								 break;
							case 7:
								$inv->addItem($WitherBoxItem7->setCount($WitherBoxAmount7));
								$sender->sendMessage($prefix . $WitherBoxBroadcast7);
								 break;
							case 8:
								$inv->addItem($WitherBoxItem8->setCount($WitherBoxAmount8));
								$sender->sendMessage($prefix . $WitherBoxBroadcast8);
								 break;
									 }
							}else{
								$prefix = $this->cfg->get("Prefix");
								$sender->sendMessage(" §fYou don't have §5WitherBox §fKey.");
							}
						break;
						case 5:
							//legendary
							$inv = $sender->getInventory();
							if($inv->contains(Item::get(131,5,1))){
								$level = $sender->getLevel();
								$x = $sender->getX();
								$y = $sender->getY();
								$z = $sender->getZ();
								$pos = new Vector3($x, $y + 2, $z);
								$pos1 = new Vector3($x, $y, $z);
								$name = $sender->getName();
								$prefix = $this->cfg->get("Prefix");

							//Item1

								$LegendaryItem1 = ItemFactory::fromString($this->cfg->getNested("Legendary.1.Item"));
								$LegendaryAmount1 = $this->cfg->getNested("Legendary.1.Amount");
								$LegendaryBroadcast1 = $this->cfg->getNested("Legendary.1.Broadcast");

							//Item2

								$LegendaryItem2 = ItemFactory::fromString($this->cfg->getNested("Legendary.2.Item"));
								$LegendaryAmount2 = $this->cfg->getNested("Legendary.2.Amount");
								$LegendaryBroadcast2 = $this->cfg->getNested("Legendary.2.Broadcast");

							//Item3

								$LegendaryItem3 = ItemFactory::fromString($this->cfg->getNested("Legendary.3.Item"));
								$LegendaryAmount3 = $this->cfg->getNested("Legendary.3.Amount");
								$LegendaryBroadcast3 = $this->cfg->getNested("Legendary.3.Broadcast");

							//Item4

								$LegendaryItem4 = ItemFactory::fromString($this->cfg->getNested("Legendary.4.Item"));
								$LegendaryAmount4 = $this->cfg->getNested("Legendary.4.Amount");
								$LegendaryBroadcast4 = $this->cfg->getNested("Legendary.4.Broadcast");

							//Item5

								$LegendaryItem5 = ItemFactory::fromString($this->cfg->getNested("Legendary.5.Item"));
								$LegendaryAmount5 = $this->cfg->getNested("Legendary.5.Amount");
								$LegendaryBroadcast5 = $this->cfg->getNested("Legendary.5.Broadcast");

							//Item6

								$LegendaryItem6 = ItemFactory::fromString($this->cfg->getNested("Legendary.6.Item"));
								$LegendaryAmount6 = $this->cfg->getNested("Legendary.6.Amount");
								$LegendaryBroadcast6 = $this->cfg->getNested("Legendary.6.Broadcast");

							//Item7

								$LegendaryItem7 = ItemFactory::fromString($this->cfg->getNested("Legendary.7.Item"));
								$LegendaryAmount7 = $this->cfg->getNested("Legendary.7.Amount");
								$LegendaryBroadcast7 = $this->cfg->getNested("Legendary.7.Broadcast");

							//Item8

								$LegendaryItem8 = ItemFactory::fromString($this->cfg->getNested("Legendary.8.Item"));
								$LegendaryAmount8 = $this->cfg->getNested("Legendary.8.Amount");
								$LegendaryBroadcast8 = $this->cfg->getNested("Legendary.8.Broadcast");

								$level->addSound(new EndermanTeleportSound($pos1));
								$level->addParticle(new LavaParticle($pos1));
								$inv->removeItem(Item::get(131,5,1));
								$sender->addTitle("§eOpening Crate:", "§9Legendary!");
								$this->getServer()->broadcastMessage($prefix . " §b$name §ajust opened §9Legendary §aCrate!");
								$result = rand(1,8);
									 switch($result){
							case 1:
								$inv->addItem($LegendaryItem1->setCount($LegendaryAmount1));
								$sender->sendMessage($prefix . $LegendaryBroadcast1);
								 break;
							case 2:
								$inv->addItem($LegendaryItem2->setCount($LegendaryAmount2));
								$sender->sendMessage($prefix . $LegendaryBroadcast2);
								 break;
							case 3:
								$inv->addItem($LegendaryItem3->setCount($LegendaryAmount3));
								$sender->sendMessage($prefix . $LegendaryBroadcast3);
								 break;
							case 4:
								$inv->addItem($LegendaryItem4->setCount($LegendaryAmount4));
								$sender->sendMessage($prefix . $LegendaryBroadcast4);
								 break;
							case 5:
								$inv->addItem($LegendaryItem5->setCount($LegendaryAmount5));
								$sender->sendMessage($prefix . $LegendaryBroadcast5);
								 break;
							case 6:
								$inv->addItem($LegendaryItem6->setCount($LegendaryAmount6));
								$sender->sendMessage($prefix . $LegendaryBroadcast6);
								 break;
							case 7:
								$inv->addItem($LegendaryItem7->setCount($LegendaryAmount7));
								$sender->sendMessage($prefix . $LegendaryBroadcast7);
								 break;
							case 8:
								$inv->addItem($LegendaryItem8->setCount($LegendaryAmount8));
								$sender->sendMessage($prefix . $LegendaryBroadcast8);
								 break;
									 }
							}else{
								$prefix = $this->cfg->get("Prefix");
								$sender->sendMessage(" §fYou don't have §9Legendary §fKey.");
							}
						break;
					}
				});

				$form->setTitle("§9Crates");
				$form->setContent("§eYou need key to open any crate!");

				$form->addButton("exit", 0, "http://pixelartmaker.com/art/36cd392e6295705.png");
				$form->addButton("§aCommon", 1, "http://xxniceyt.ga/games/Vote.jpg");
				$form->addButton("§cVote", 2, "http://xxniceyt.ga/games/Common.jpg");
				$form->addButton("§6Rare", 3, "http://xxniceyt.ga/games/Rare.jpg");
				$form->addButton("§cWither§fBox", 4, "http://xxniceyt.ga/games/Mythic.jpg");
				$form->addButton("§9Legendary", 5, "http://xxniceyt.ga/games/Legendary.jpg");

				$form->sendToPlayer($sender);
			 }else{
				 $sender->sendMessage("§cYou are not In-Game.");
			 }
			 return true;
		}
	}
}
