<?php


namespace App\EventListener;

use App\Entity\Car;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Symfony\Component\Filesystem\Filesystem;

class CarListener
{
    private $imageDirectory;

    public function __construct(string $imageDirectory)
    {
        $this->imageDirectory = $imageDirectory;
    }

    public function preRemove(PreRemoveEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        // Vérifie si l'entité est de type Car
        if (!$entity instanceof Car) {
            return;
        }

        $filesystem = new Filesystem();
        $imagePath = $this->imageDirectory . '/' . $entity->getImage();

        if ($entity->getImage() && $filesystem->exists($imagePath)) {
            $filesystem->remove($imagePath);
        }
    }
}
