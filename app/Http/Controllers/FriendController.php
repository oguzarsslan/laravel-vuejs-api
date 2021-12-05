<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FriendController extends Controller
{
    public function getFriends()
    {
        $user = auth()->user();
        $friends = $user->getAcceptedFriendships();

        foreach ($friends as $item) {
            if ($item['sender_id'] == $user['id']) {
                $item['item'] = User::find($item['recipient_id']);
            } else {
                $item['item'] = User::find($item['sender_id']);
            }
        }

        return response()->json($friends);
    }

    public function getRequest()
    {
        $user = auth()->user();
        $friendRequest = $user->getPendingFriendships()->where('recipient_id', $user['id']);

        foreach ($friendRequest as $item) {
            $item['item'] = User::find($item['sender_id']);
        }

        return response()->json($friendRequest);
    }

    public function getSent()
    {
        $user = auth()->user();
        $friendRequest = $user->getPendingFriendships()->where('sender_id', $user['id']);

        foreach ($friendRequest as $item) {
            $item['item'] = User::find($item['recipient_id']);
        }

        return response()->json($friendRequest);
    }

    public function getBlocked()
    {
        $user = auth()->user();
        $friendRequest = $user->getBlockedFriendships()->where('sender_id', $user['id']);

        foreach ($friendRequest as $item) {
            $item['item'] = User::find($item['recipient_id']);
        }

        return response()->json($friendRequest);
    }

    public function addFriend(Request $request)
    {
        $arg = $request->only('id');

        $user = auth()->user();
        $recipient = User::find($arg['id']);

        $user->befriend($recipient);

        return response('sent');
    }

    public function acceptFriend(Request $request)
    {
        $arg = $request->only('id');
        $user = auth()->user();
        $sender = User::find($arg['id']);

        $user->acceptFriendRequest($sender);

        return response('accepted');
    }

    public function removeFriend(Request $request)
    {
        $arg = $request->only('id');
        $user = auth()->user();
        $friend = User::find($arg['id']);

        $user->unfriend($friend);

        return response('remove');
    }

    public function blockFriend(Request $request)
    {
        $arg = $request->only('id');
        $user = auth()->user();
        $friend = User::find($arg['id']);

        $user->blockFriend($friend);

        return response('blocked');
    }

    public function unblockFriend(Request $request)
    {
        $arg = $request->only('id');
        $user = auth()->user();
        $friend = User::find($arg['id']);

        $user->unblockFriend($friend);

        return response('unblocked');
    }
}
