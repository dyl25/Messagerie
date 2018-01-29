<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\ConversationRepository;
use Illuminate\Http\Request;
use App\User;

/**
*
*/
class ConversationsController extends Controller
{

    private $cr;

    public function __construct(ConversationRepository $cr) {
        $this->cr = $cr;
    }

    public function index(Request $request) {
        return response()
        ->json([
            'conversations' => $this->cr->getConversations($request->user()->id)
        ]);
    }

    public function show(Request $request, User $user) {
        $messages = $this->cr->getMessagesFor($request->user()->id, $user->id)->get();
        return [
            'messages' => $messages->reverse()
        ];
    }
}
