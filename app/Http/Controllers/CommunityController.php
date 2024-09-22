<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\Community;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all();
        return view('communities.index', compact('communities'));
    }
    
    public function create()
    {
        return view('communities.create');
    }

    public function store(Request $request)
    {
        $community = Community::create($request->all());
        return redirect()->route('communities.index');
    }

    public function show(Community $community)
    {
        $posts = $community->communityPosts()->paginate(10);
        return view('communities.show', compact('community', 'posts'));
    }
}
