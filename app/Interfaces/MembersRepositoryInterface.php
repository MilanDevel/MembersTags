<?php
namespace App\Interfaces;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Members and their tags
 */
interface MembersRepositoryInterface{
    /**
     * Get collection with all members
     * @param bool $withTags Return result with tags if set to true value, without tags if set to false
     * @return Collection
     */
    public function getAllMembers(bool $withTags): Collection;

    /**
     * Get member by ID
     * @param int $memberId
     * @param bool $withTags Return result with tags if set to true value, without tags if set to false
     * @return Member
     */
    public function getMember(int $memberId, bool $withTags): Member;

    /**
     * Create new member
     * @param array $memberDetails JSON with Member values
     * @return Member
     */
    public function createMember(array $memberDetails): Member;

    /**
     * Update member data
     * @param int $memberId Member ID
     * @param array $memberDetails JSON with Member values
     * @return bool
     */
    public function updateMember(int $memberId, array $memberDetails): bool;

    /**
     * Delete selected member
     * @param int $memberId Member ID
     * @return int
     */
    public function deleteMember(int $memberId): int;

    /**
     * Attach existing tag to selected member
     * @param int $memberId Member ID
     * @param int $tagId Tag ID
     * @return array
     */
    public function createMemberTag(int $memberId, int $tagId): array;

    /**
     * Detach tag from selected member
     * @param int $memberId Member ID
     * @param int $tagId Tag ID
     * @return int
     */
    public function deleteMemberTag(int $memberId, int $tagId): int;
}
