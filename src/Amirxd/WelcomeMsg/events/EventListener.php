<?php

namespace Amirxd\WelcomeMsg\events;

use Amirxd\WelcomeMsg\WelcomeMessage;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\world\particle\EndermanTeleportParticle;
use pocketmine\world\particle\FlameParticle;
use pocketmine\world\particle\HappyVillagerParticle;
use pocketmine\world\particle\HeartParticle;
use pocketmine\world\particle\LavaParticle;
use pocketmine\world\particle\PortalParticle;
use pocketmine\world\sound\PopSound;

class EventListener implements \pocketmine\event\Listener
{
    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $plugin = WelcomeMessage::getInstance();
        $config = $plugin->getWelcomeConfig();

        if($config->getNested("welcome-message.enabled", true)) {
            $message = $config->getNested("welcome-message.message", "§6Welcome {player}!");
            $message = str_replace("{player}", $player->getName(), $message);

            if($config->getNested("welcome-message.broadcast-to-all", true)) {
                $plugin->getServer()->broadcastMessage($message);
            } else {
                $player->sendMessage($message);
            }
        }

        if($config->getNested("title.enabled", true)) {
            $title = str_replace("{player}", $player->getName(),
                $config->getNested("title.title", "§bWelcome!"));
            $subtitle = $config->getNested("title.subtitle", "§7Enjoy your stay!");

            $player->sendTitle($title, $subtitle,
                $config->getNested("title.fadein", 20),
                $config->getNested("title.stay", 60),
                $config->getNested("title.fadeout", 20)
            );
        }


        if($config->getNested("effects.sound")) {
            $player->getWorld()->addSound($player->getPosition(), new PopSound());
        }

        if($config->getNested("effects.particles", true)) {
            $this->ApplyParticles($player);
        }
    }

    public function ApplyParticles(Player $player): void
    {
        $config = WelcomeMessage::getInstance()->getWelcomeConfig();
        $particleType = $config->getNested("effects.particle-type", "HappyVillager");
        $count = $config->getNested("effects.particle-count", 10);

        $particles = [
            "HappyVillager" => new HappyVillagerParticle(),
            "Heart" => new HeartParticle(),
            "Flame" => new FlameParticle(),
            "Lava" => new LavaParticle(),
            "Portal" => new PortalParticle(),
            "Enderman" => new EndermanTeleportParticle()
        ];

        $particle = $particles[$particleType] ?? $particles["HappyVillager"];

        for($i = 0; $i < $count; $i++) {
            $pos = $player->getPosition()->add(
                mt_rand(-2, 2),
                mt_rand(0, 3),
                mt_rand(-2, 2)
            );
            $player->getWorld()->addParticle($pos, $particle);
        }
    }
}