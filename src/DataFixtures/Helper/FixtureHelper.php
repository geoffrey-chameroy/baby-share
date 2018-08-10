<?php

namespace App\DataFixtures\Helper;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as Faker;
use Faker\Generator;

abstract class FixtureHelper extends Fixture
{
    const NB_PHOTO = 12;

    private $urlImages = 'https://picsum.photos';

    /** @var Generator */
    public $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    protected function getImage(string $directory, int $width = 640, int $height = 400, bool $random = true, int $number = 1): string
    {
        $imageUrl = sprintf('%s/%s/%s', $this->urlImages, $width, $height);
        if (true === $random) {
            $imageUrl .= '?random';
        } else {
            $imageUrl .= '?image=' . $number;
        }

        $filename = md5(uniqid('', true) . rand(1, 100000)) . '.jpg';
        file_put_contents($directory . '/' . $filename, file_get_contents($imageUrl));

        return $filename;
    }
}
