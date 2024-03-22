<?php

namespace App\Repositories;

use App\Interfaces\MembersRepositoryInterface;
use App\Models\Member;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class MembersRepository implements MembersRepositoryInterface{
    public function getAllMembers(bool $withTags): Collection {
        return $withTags ? Member::with('tag')->get() :
         Member::all();
    }

    public function getMember($memberId, bool $withTags): Member {
        return $withTags ? Member::with('tag')->findOrFail($memberId) :
         Member::findOrFail($memberId);
    }

    public function createMember(array $memberDetails): Member {
        return Member::create($memberDetails);
    }

    public function updateMember($memberId, array $memberDetails): bool {
        return Member::findOrFail($memberId)->update($memberDetails);
    }

    public function deleteMember($memberId): int {
        return Member::destroy($memberId);
    }

    public function createMemberTag($memberId, $tagId): array {
        Tag::findOrFail($tagId);
        return Member::findOrFail($memberId)->tag()->sync([$tagId], false);
    }

    public function deleteMemberTag($memberId, $tagId): int {
        return Member::findOrFail($memberId)->tag()->detach($tagId);
    }
}
