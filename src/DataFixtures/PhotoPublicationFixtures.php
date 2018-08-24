<?php

namespace App\DataFixtures;

use App\DataFixtures\Helper\FixtureHelper;
use App\Entity\PhotoPublication;
use Doctrine\Common\Persistence\ObjectManager;

class PhotoPublicationFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::NB_PHOTO_PUBLICATION; $i++) {
            $publication = (new PhotoPublication())
                ->setPublishedAt(new \DateTime());

            $this->setReference('photo-publication-' . $i, $publication);
            $manager->persist($publication);
        }
        $manager->flush();
    }
}
