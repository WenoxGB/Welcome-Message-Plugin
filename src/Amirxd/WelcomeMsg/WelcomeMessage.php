<?php

namespace Amirxd\WelcomeMsg;

use Amirxd\WelcomeMsg\events\EventListener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;


class WelcomeMessage extends \pocketmine\plugin\PluginBase
{
    public string $tag = TF::GRAY . "[" . TF::GREEN . "Welcome " . TF::YELLOW . "Message" . TF::GRAY . "] ";
    private static self $instance;

    public function onLoad(): void
    {
    self::$instance = $this;
    }

    public static function getInstance():self
    {
        return self::$instance;
    }

    public function onEnable(): void
    {
    $this->getLogger()->info($this->tag . TF::GREEN . "Enabled");
    $this->saveDefaultConfig();
    $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

    }

    public function getWelcomeConfig(): Config {
        return $this->getConfig();
    }


}