<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Interaction;

use OpenApi\Annotations as OA;

class PeopleController extends Controller
{

    protected function getUserId(Request $request): ?int
    {
        $userId = $request->header('X-User-Id');

        return $userId ? (int) $userId : null;
    }

    /**
     * @OA\Get(
     *     path="/api/people",
     *     summary="List recommended people",
     *     tags={"People"},
     *     @OA\Parameter(
     *         name="X-User-Id",
     *         in="header",
     *         required=true,
     *         description="Current user ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number for pagination",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page (max 50)",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing X-User-Id header"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $userId = $this->getUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'X-User-Id header is required',
            ], 400);
        }

        $perPage = min($request->get('per_page', 10), 50);

        $interactedIds = Interaction::where('user_id', $userId)
            ->pluck('person_id')
            ->toArray();

        $people = Person::where('id', '!=', $userId)
            ->whereNotIn('id', $interactedIds)
            ->paginate($perPage);

        return response()->json($people);
    }

    /**
     * @OA\Post(
     *     path="/api/people/{id}/like",
     *     summary="Like a person",
     *     tags={"People"},
     *     @OA\Parameter(
     *         name="X-User-Id",
     *         in="header",
     *         required=true,
     *         description="Current user ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Person ID to like",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person liked"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error (missing header or like yourself)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Person not found"
     *     )
     * )
     */
    public function like(Request $request, $id)
    {
        $userId = $this->getUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'X-User-Id header is required',
            ], 400);
        }

        if ((int)$userId === (int)$id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot like yourself',
            ], 400);
        }

        $person = Person::find($id);

        if (!$person) {
            return response()->json([
                'success' => false,
                'message' => 'Person not found',
            ], 404);
        }

        $interaction = Interaction::updateOrCreate(
            [
                'user_id'   => $userId,
                'person_id' => $id,
            ],
            [
                'type' => 'like',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Person liked',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/people/{id}/dislike",
     *     summary="Dislike a person",
     *     tags={"People"},
     *     @OA\Parameter(
     *         name="X-User-Id",
     *         in="header",
     *         required=true,
     *         description="Current user ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Person ID to dislike",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person disliked"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error (missing header or dislike yourself)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Person not found"
     *     )
     * )
     */
    public function dislike(Request $request, $id)
    {
        $userId = $this->getUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'X-User-Id header is required',
            ], 400);
        }

        if ((int)$userId === (int)$id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot dislike yourself',
            ], 400);
        }

        $person = Person::find($id);

        if (!$person) {
            return response()->json([
                'success' => false,
                'message' => 'Person not found',
            ], 404);
        }

        $interaction = Interaction::updateOrCreate(
            [
                'user_id'   => $userId,
                'person_id' => $id,
            ],
            [
                'type' => 'dislike',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Person disliked',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/people/liked",
     *     summary="List liked people",
     *     tags={"People"},
     *     @OA\Parameter(
     *         name="X-User-Id",
     *         in="header",
     *         required=true,
     *         description="Current user ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page (max 50)",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of liked people"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing X-User-Id header"
     *     )
     * )
     */
    public function likedPeople(Request $request)
    {
        $userId = $this->getUserId($request);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'X-User-Id header is required',
            ], 400);
        }

        $perPage = min($request->get('per_page', 10), 50);

        $liked = Interaction::where('user_id', $userId)
            ->where('type', 'like')
            ->with('target')
            ->paginate($perPage);

        $people = $liked->getCollection()->map(function ($interaction) {
            return $interaction->target;
        })->values();

        return response()->json([
            'success' => true,
            'data' => $people,
        ]);
    }
}
