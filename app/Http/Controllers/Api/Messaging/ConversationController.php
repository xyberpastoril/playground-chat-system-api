<?php

namespace App\Http\Controllers\Api\Messaging;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Messaging\CreateConversationRequest;
use App\Http\Requests\Api\Messaging\ReplyMessageRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * An API endpoint to create a new conversation.
     */
    public function create(CreateConversationRequest $request)
    {
        $validated = $request->validated();

        // Check if the authenticated user already has an existing
        // conversation with the receiver user
        $conversation = Conversation::whereHas('participants', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereHas('participants', function ($query) use ($validated) {
            $query->where('user_id', $validated['receiver_user_id']);
        })->first();

        // If the conversation does not exist, create a new one
        if(!$conversation)
        {
            // Create a new conversation
            $conversation = Conversation::create([
                'creator_user_id' => Auth::id(),
            ]);

            // Create conversation participants
            $conversation_participants = ConversationParticipant::insert([
                [
                    'conversation_id' => $conversation->id,
                    'user_id' => Auth::id(),
                ],
                [
                    'conversation_id' => $conversation->id,
                    'user_id' => $validated['receiver_user_id'],
                ],
            ]);
        }

        // Create the first message of the conversation
        $conversation->messages()->create([
            'body' => $validated['body'],
            'sender_user_id' => Auth::id(),
        ]);

        $conversation->participants;
        $conversation->messages;

        // Return response
        return response()->json([
            'message' => 'Message sent successfully.',
            'conversation' => $conversation,
        ], 201);
    }

    /**
     * Get the conversation, participants and the messages.
     */
    public function get(Conversation $conversation)
    {
        // Check if the authenticated user is a participant of the conversation
        if(!$conversation->participants->contains('user_id', Auth::id()))
        {
            return response()->json([
                'message' => 'You are not a participant of this conversation.',
            ], 403);
        }

        $conversation->messages;
        $conversation->participants;

        // Return response
        return response()->json([
            'message' => 'Conversation retrieved successfully.',
            'conversation' => $conversation,
        ], 200);
    }

    /**
     * An API endpoint to reply to a conversation.
     */
    public function reply(ReplyMessageRequest $request, Conversation $conversation)
    {
        $validated = $request->validated();

        // Store the message
        $conversation->messages()->create([
            'body' => $validated['body'],
            'sender_user_id' => Auth::id(),
        ]);

        // Return response
        return response()->json([
            'message' => 'Message sent successfully.',
            'conversation' => $conversation,
        ], 201);
    }
}
