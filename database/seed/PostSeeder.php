<?php


use Phinx\Seed\AbstractSeed;
use Shared\Model\Domain\Common\Slug;

class PostSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 34; $i++) {
            $name = rtrim($faker->sentence(6), '.');
            $contentParagraphs = array_map(function ($item) {
                return "<p>$item</p>";
            }, $faker->paragraphs(3));
            $data[] = [
                'name' => $name,
                'slug' => Slug::createFromString($name),
                'content' => $faker->boolean(70) ? implode("\n", $contentParagraphs) : null,
                'creationDate' => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('Post', $data);
    }
}
