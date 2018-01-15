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
     * @param int $userId The id of the auth user
     * @return All the conversations and their data
     */
    public function getConversations(int $userId) {
        //we get all users except the current user
        return $this->user->newQuery()
                ->select('name', 'id')
                ->where('id', '!=', $userId)
                ->get();

        /*$unread = $this->unreadCount($userId);

        foreach ($conversations as $conversation) {
            if (isset($unread[$conversation->id])) {
                $conversation->unread = $unread[$conversation->id];
            } else {
                $conversation->unread = 0;
            }
        }*/

        //return $conversations;
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
                        ->orderBy('created_at', 'DESC')
                        ->with(['from' => function($query) {
                                return $query->select('name', 'id');
                            }]);
    }

    /**
     * Get unread number of messages for each conversation
     * @param int $userId The id of the current auth user
     * @return An array with the number of unread messages
     */
    public function unreadCount(int $userId) {
        return $this->message->newQuery()
                        ->where('to_id', $userId)
                        ->groupBy('from_id')
                        ->selectRaw('from_id, COUNT(id) as count')
                        ->whereRaw('read_at IS NULL')
                        ->get()
                        ->pluck('count', 'from_id');
    }

    public function readAllFrom(int $from, int $to) {
        $this->message
                ->where('from_id', $from)
                ->where('to_id', $to)
                ->update(['read_at' => Carbon::now()]);
    }
    
}
