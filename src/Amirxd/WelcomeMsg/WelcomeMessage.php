<?php

namespace Amirxd\WelcomeMsg;

use Amirxd\WelcomeMsg\events\EventListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat as TF;

class WelcomeMessage extends PluginBase
{
    use SingletonTrait;
    public string $tag = TF::GRAY . "[" . TF::GREEN . "Welcome " . TF::YELLOW . "Message" . TF::GRAY . "] ";

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}
