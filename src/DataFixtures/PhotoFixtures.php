<?php

namespace App\DataFixtures;

use App\DataFixtures\Helper\FixtureHelper;
use App\Entity\Photo;
use App\Entity\PhotoPublication;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class PhotoFixtures extends FixtureHelper implements DependentFixtureInterface
{
    /** @var KernelInterface */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $directory = $this->kernel->getRootDir() . '/../uploads/';
        /** @var User $uploadedBy */
        $uploadedBy = $this->getReference('user');
        for ($i = 1; $i <= self::NB_PHOTO; $i++) {
            $publication = null;
            if ($i > 3) {
                /** @var PhotoPublication $publication */
                $publication = $this->getReference('photo-publication-' . $this->faker->numberBetween(1, self::NB_PHOTO_PUBLICATION));
            }
            $photo = (new Photo())
                ->setLabel($this->faker->sentence)
                ->setDescription($this->faker->text)
                ->setFileName($this->getImage($directory, 640, 480, false, $i))
                ->setTakenAt(new \DateTime())
                ->setPublication($publication)
                ->setUploadedBy($uploadedBy);

            $this->setReference('photo-' . $i, $photo);
            $manager->persist($photo);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PhotoPublicationFixtures::class,
        ];
    }
}
