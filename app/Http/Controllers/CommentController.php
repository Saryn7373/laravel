<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\Comment;
use App\Models\Article;
use App\Mail\CommentMail;
use Illuminate\Http\Request;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::latest() -> paginate(5);
        return view("comment.comments", ['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "text" => "min:10 | required"
        ]);
        $article = Article::FindOrFail($request->article_id);
        $comment = new Comment();
        $comment->text = $request->text;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->id();
        if($comment->save())
            Mail::to(env('MAIL_USERNAME'))->send(new CommentMail($comment, $article));
        return redirect()->route('article.show', $request->article_id)->with('message', "Comment add succesful");
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        Gate::authorize('comment', $comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('comment', $comment);
        return 0;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('comment', $comment);
        return 0;       
    }
}
