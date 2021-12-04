<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Multicaret\Acquaintances\Models\InteractionRelation;

class FriendController extends Controller
{
    public function getFriends(Request $request)
    {
        $user = auth()->user();
        $friends = $user->getAcceptedFriendships();

        foreach ($friends as $item) {
            $item['item'] = User::find($item['recipient_id']);
        }

        return response($friends);
    }

    public function addFriend(Request $request)
    {
//        $user = auth()->user();
        $user = User::find(12);
        $recipient = User::find(1);

        $user->befriend($recipient);

        return response('sent');
    }

    public function acceptFriend(Request $request)
    {
        $user = User::find(6);
        $sender = auth()->user();

        $user->acceptFriendRequest($sender);

        return response('accepted');
    }

    public function denyFriend(Request $request)
    {
        $user = User::find(3);
        $sender = User::find(1);

        $user->denyFriendRequest($sender);

        return response('deny');
    }

    public function removeFriend(Request $request)
    {
        $user = User::find(1);
        $friend = User::find(3);

        $user->unfriend($friend);

        return response('remove');
    }

    public function blockFriend(Request $request)
    {
        $user = User::find(1);
        $friend = User::find(4);

        $user->blockFriend($friend);

        return response('blocked');
    }

    public function unblockFriend(Request $request)
    {
        $user = User::find(1);
        $friend = User::find(4);

        $user->unblockFriend($friend);

        return response('unblocked');
    }
}
