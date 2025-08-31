<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json(Member::query()->latest('member_id')->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'role' => 'required|string|max:100',
            'image_url' => 'nullable|url|max:2048',
            'team' => 'nullable|string|max:255',
        ]);

        $member = Member::create($data);
        return response()->json($member, Response::HTTP_CREATED);
    }

    public function show(Member $member)
    {
        return response()->json($member);
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:members,email,' . $member->getKey() . ',member_id',
            'role' => 'sometimes|required|string|max:100',
            'image_url' => 'nullable|url|max:2048',
            'team' => 'nullable|string|max:255',
        ]);

        $member->update($data);
        return response()->json($member);
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
