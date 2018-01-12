<?php

namespace App\Http\Controllers;

use App\Repository\ConversationRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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
            'users' => $this->cr->getConversations($this->auth->user()->id)
        ]);
    }

    public function show(User $user) {
        return view('conversations/show', [
            'users' => $this->cr->getConversations($this->auth->user()->id),
            'user' => $user
        ]);
    }

    public function store(User $user, Request $request) {
        $this->cr->createMessage(
                $request->get('content'), 
                $this->auth->user()->id, 
                $user->id
        );
        
        return back();
        
    }

}
