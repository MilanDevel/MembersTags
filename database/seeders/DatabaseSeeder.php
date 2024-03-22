<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /// Seeder settings
        $tagsCount = 5;
        $membersCount = 10;
        $tagsForMemberCount = 3;
        /// End Seeder settings

        $tagsForMemberCount = min($tagsCount, $tagsForMemberCount);
        $tags = Tag::factory()->count($tagsCount)->create()->all();
        $members = Member::factory()->count($membersCount)->create();

        foreach($members as $member){
            $random = rand(0, $tagsForMemberCount);

            $randomTags = $this->getRandomTags($tags, $random);

            for($i = 0; $i < $random; $i++){
                $member->tag()->attach($tags[$randomTags[$i]]);
            }
        }
    }

    private function getRandomTags(array $tags, int $count): array
    {
        if ($count <= 0)
            return [];

        $result = array_rand($tags, $count);

        return $count === 1 ? [$result] : $result;
    }
}
