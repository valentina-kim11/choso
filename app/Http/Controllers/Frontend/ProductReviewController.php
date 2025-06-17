<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ProductReview,Product,Order};
use Validator;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'comment' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'pid' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);
        }

        $product = Product::where('slug', $request->pid)->first();
        if (!$product) {
            return response()->json(['status' => false, 'msg' => trans('frontend_msg.something_went_wrong')], 200);
        }

        $order = Order::where(['user_id' => auth()->id(), 'tnx_id' => $request->txid, 'status' => 1])->first();
        if (!$order) {
            return response()->json(['status' => false, 'msg' => trans('frontend_msg.something_went_wrong')], 200);
        }

        $review = ProductReview::firstOrNew(['id' => $request->rid]);
        $review->order_id = $order->id;
        $review->product_id = $product->id;
        $review->user_id = auth()->id();
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        $rating = ProductReview::where('product_id', $product->id)->avg('rating');
        $product->rating = $rating;
        $product->save();

        return response()->json([
            'status' => true,
            'msg' => trans('frontend_msg.review_succ'),
            'url' => route('frontend.profile', [app()->getLocale(), 'tab' => 'my-downloads'])
        ], 200);
    }

    public function ajax_search(Request $request)
    {
        $query = ProductReview::query()->where('product_id', $request->product_id);
        if ($request->rating) {
            $query->where('rating', $request->rating);
        }
        $query->orderBy('id', 'DESC');
        $data = $query->paginate(10);
        $html = view('frontend.search.rating_search', ['data' => $data])->render();
        return response()->json([
            'status' => true,
            'html_response' => $html,
            'last_page' => $data->lastPage(),
            'current_page' => $data->currentPage(),
        ], 200);
    }
}
