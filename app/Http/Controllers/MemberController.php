<?php

namespace App\Http\Controllers;

use App\Interfaces\MembersRepositoryInterface;
use App\Models\Member;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Member controller
 */
class MemberController extends Controller
{
    private MembersRepositoryInterface $membersRepository;

    public function __construct(MembersRepositoryInterface $memberRepo)
    {
        $this->membersRepository = $memberRepo;
    }

    /**
     * Get JSON with all Members data
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $withTags = $request->query('withTags', false);
        return response()->json($this->membersRepository->getAllMembers($withTags));
    }

    /**
     * Get JSON data for selected Member
     *
     * @param mixed   $id Member ID
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function show(mixed $id, Request $request): JsonResponse
    {
        if (!is_numeric($id))
            return response()->json(['message' => 'Key must be numeric!'], 400);

        $withTags = $request->query('withTags', false);

        try {
            $result = $this->membersRepository->getMember($id, $withTags);

        } catch (ModelNotFoundException){
            return response()->json(['message' => 'Member not found!'], 404);
        }

        return response()->json($result);
    }

    /**
     * Create new Member
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'firstname' => ['required', 'max:30'],
            'lastname' => ['required', 'max:30'],
            'email' => ['required', 'email', 'max:50'],
            'birthdate' => ['required', 'date'],
            'phone' => ['required', 'max:20'],
        ]);

        return response()->json($this->membersRepository->createMember($data));
    }

    /**
     * Update Member
     *
     * @param mixed   $id Member ID
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function update(mixed $id, Request $request)
    {
        if (!is_numeric($id))
            return response()->json(['message' => 'Key must be numeric!'], 400);

        $data = $request->validate([
            'firstname' => ['required', 'max:30'],
            'lastname' => ['required', 'max:30'],
            'email' => ['required', 'email', 'max:50'],
            'birthdate' => ['required', 'date'],
            'phone' => ['required', 'max:20'],
        ]);

        try {
            $result = $this->membersRepository->updateMember($id, $data);
            if ($result)
                return response()->noContent();
        } catch (ModelNotFoundException) {}

        return response()->json(['message' => 'Member not found!'], 404);
    }

    /**
     * Delete selected Member
     *
     * @param mixed $id Member ID
     *
     * @return JsonResponse|Response
     */
    public function destroy(mixed $id)
    {
        if (!is_numeric($id))
            return response()->json(['message' => 'Key must be numeric!'], 400);

        if ($this->membersRepository->deleteMember($id) > 0)
            return response()->noContent();
        else
            return response()->json(['message' => 'Member not found!'], 404);
    }

    /**
     * Attach Tag to selected Member
     *
     * @param mixed   $id Member ID
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function storeTag(mixed $id, Request $request)
    {
        if (!is_numeric($id))
            return response()->json(['message' => 'Key must be numeric!'], 400);

        $request->validate(['tag_id' => ['required']]);
        $data = $request->input('tag_id');

        try {
            $result = $this->membersRepository->createMemberTag($id, $data);
        } catch (ModelNotFoundException){
            return response()->json(['message' => 'Member or Tag not found!'], 404);
        }

        return response()->noContent();
    }

    /**
     * Detach selected Tag from selected Member
     *
     * @param mixed $id Member ID
     * @param mixed $tid Tag ID
     *
     * @return JsonResponse|Response
     */
    public function destroyTag(mixed $id, mixed $tid)
    {
        if (!is_numeric($id))
            return response()->json(['message' => 'Member key must be numeric!'], 400);

        if (!is_numeric($tid))
            return response()->json(['message' => 'Tag key must be numeric!'], 400);

        try {
            $result = $this->membersRepository->deleteMemberTag($id, $tid);
            if ($result > 0)
                return response()->noContent();

        } catch (ModelNotFoundException) {}
        return response()->json(['message' => 'Member or Tag not found!'], 404);
    }
}
