<?php

namespace App\Http\Controllers;

use App\Repository\ConversationRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMessageRequest;

class ConversationsController extends Controller {

    private $cr;

    public function __construct(
    ConversationRepository $conversationRepository, AuthManager $auth
    ) {
        $this->cr = $conversationRepository;
        $this->auth = $auth;
    }

    public function index() {
        //we get all users except the current user
        return view('conversations/index', [
            'users' => $this->cr->getConversations($this->auth->user()->id),
            'unread' => $this->cr->unreadCount($this->auth->user()->id)
        ]);
    }

    public function show(User $user) {
        $me = $this->auth->user();
        
        $messages = $this->cr
                    ->getMessagesFor($me->id, $user->id)
                    ->paginate(40);
        
        $unread = $this->cr->unreadCount($me->id);
        
        if(isset($unread[$user->id])) {
            $this->cr->readAllFrom($user->id, $me->id);
            unset($unread[$user->id]);
        }
        
        return view('conversations/show', [
            'users' => $this->cr->getConversations($this->auth->user()->id),
            'user' => $user,
            'messages' => $messages,
            'unread' => $unread
        ]);
    }

    public function store(User $user, StoreMessageRequest $request) {
        $this->cr->createMessage(
                $request->get('content'), $this->auth->user()->id, $user->id
        );

        return back();
    }

}
