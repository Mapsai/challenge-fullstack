<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use stdClass;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentController extends Controller
{
    private $user = null;

    public function all(Request $req): JsonResponse
    {
        try {
            $this->validateAuth($req);

            $comments = Comment::with('user')->get()->sortDesc();
            $response = [];

            foreach ($comments as $comment) {
                $updatedPayload = new stdClass();
                $updatedPayload->body = $comment->body;
                $updatedPayload->user = $comment->user->name;
                $updatedPayload->date = $comment->created_at->isoFormat('h:MM A');

                $response[] = $updatedPayload;
            }

            return response()->json(['success' => true, 'message' => $response]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function comment(Request $req): JsonResponse
    {
        try {
            $this->validateAuth($req);

            if (!$req->comment) {
                throw new BadRequestHttpException('Missing form data');
            }

            $comment = new Comment([
                'user_id' => $this->user->id,
                'body' => $req->comment,
            ]);

            $saved = $comment->save();

            if (!$saved) {
                throw new BadRequestHttpException('Failed to save comment');
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function validateAuth(Request $req): void {
        if (!$req->authToken) {
            throw new BadRequestHttpException('Unauthorized');
        }

        $this->user = User::query()
            ->where('token', '=', $req->authToken)
            ->where('token_valid_until', '>=', date('Y-m-d H:i:s'))
            ->first();

        if (!$this->user) {
            throw new BadRequestHttpException('Unauthorized');
        }
    }
}
