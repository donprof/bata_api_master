<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentFormRequest;
use App\Models\Comments\Comments;

class CommentsController extends Controller
{
    public function index(Request $request)
    {
        $makes = Bases::bases();
        return response($makes);
    }

    public function store(CommentFormRequest $request)
    {
        $comment = Comments::create([
            'product_id'    => $request->product,
            'comment'       => $request->comment,
            'user_id'       => request()->user()->id,
            'status'        => 0
        ]);

        return response()->json(['data' => $comment], 201);
    }

    public function update(BasesUpdateFormRequest $request, $id)
    {
        $make = Comments::findOrFail(intval($id));

        $make->description = $request->description;
        $make->save();
        return response()->json(['data' => $make], 200);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if ($request->search != null) {
            $ceter = request()->user()->costCenter;
            $base = Bases::with(["user"])->where('costCenter', $ceter)->where('description', 'LIKE', '%' . $search . '%')->orderBy("id", "ASC")->paginate(15);
            return response($base);
        }
    }
}
