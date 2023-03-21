<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static array $articleTitles = [
        'Facebook ест твои данные',
        'Что делать, если надо верстать?',
        'Когда пролил кофе на клавиатуру',
    ];

    private static array $articleImages = [
        'article-1.jpeg',
        'article-2.jpeg',
        'article-3.jpg',
    ];

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 10, function (Article $article) use ($manager) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setDescription('Duis gravida symfony libero et dolor viverra imperdiet')
                ->setBody('Duis **кофе** symfony libero et dolor viverra imperdiet eu non sem. Curabitur in eleifend est.
                Maecenas et porttitor erat. [Donec](/) in faucibus felis, ullamcorper tristique nibh.
                ' . $this->faker->paragraph($this->faker->numberBetween(2, 5), true))
            ;

            if ($this->faker->boolean(60)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article
                ->setAuthor($this->getRandomReference(User::class))
                ->setVoteCount($this->faker->numberBetween(0, 10))
                ->setImageFilename($this->faker->randomElement(self::$articleImages))
            ;

            /** @var Tag[] $tags */
            $tags = [];
            for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
                $tags[] =$this->getRandomReference(Tag::class);
            }

            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

        });
    }


    public function getDependencies()
    {
        return [
            TagFixtures::class,
            UserFixtures::class
        ];
    }
}
