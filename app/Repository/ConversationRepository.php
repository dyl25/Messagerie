<?php

namespace App\Repository;

use App\User;
use App\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Description of ConversationRepository
 *
 * @author admin
 */
class ConversationRepository {

    private $user;
    private $message;

    public function __construct(User $user, Message $message) {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get all the conversations
     * @param int $userId The id of the user
     * @return type
     */
    public function getConversations(int $userId) {
        //we get all users except the current user
        return $this->user->newQuery()
                        ->select('name', 'id')
                        ->where('id', '!=', $userId)
                        ->get();
    }
    
    /**
     * Create a message with a sender and a receiver
     * @param string $content The content of the message
     * @param int $from Id of the sender
     * @param int $to Id of the receiver
     */
    public function createMessage(string $content, int $from, int $to) {
        return $this->message->newQuery()->create([
            'content' => $content,
            'from_id' => $from,
            'to_id' => $to
            //'created_at' => Carbon::now()
        ]);
    }
    
    public function getMessagesFor(int $from, int $to): Builder {
        return $this->message->newQuery()
                ->whereRaw("((from_id = $from AND to_id = $to) OR (from_id = $to AND to_id = $from))")
                ->orderBy('created_at', 'DESC');
    }

}
