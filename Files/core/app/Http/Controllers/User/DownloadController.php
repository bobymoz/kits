<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Transaction;
use Illuminate\Http\Request;



class DownloadController extends Controller
{
    public function index()
    {
        $pageTitle = 'Your Downloadable Products';
        $downloads = Download::where('user_id', auth()->user()->id)->latest()->with('product')->paginate(getPaginate());
        return view('Template::user.downloaded', compact('pageTitle', 'downloads'));
    }


    public function productOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|gt:0'
        ]);

        $user = auth()->user();
        $product = Product::active()->where('id',$request->product_id)->first();
        if (!$product) {
            $notify[] = ['error', 'Product not found.'];
            return to_route('home')->withNotify($notify);
        }

        return $this->handleProductDownload($user, $product);
    }

    private function handleFreeProduct($user, $product)
    {
        $order = new Download();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $order->save();

        $product->download += 1;
        $product->save();

        $notify[] = ['success', 'Successfully Granted, You can download your product from here!'];
        return to_route('user.download.index')->withNotify($notify);
    }

    private function handlePaidProduct($user, $product)
    {
        if ($user->balance >= $product->price) {
            $user->balance -= $product->price;
            $user->save();

            $trx = new Transaction();
            $trx->user_id      = $user->id;
            $trx->amount       = $product->price;
            $trx->post_balance = $user->balance;
            $trx->trx_type     = '-';
            $trx->trx          = getTrx();
            $trx->remark       = 'Purchase';
            $trx->details      = 'Purchase product - From Balance';
            $trx->save();

            $order = new Download();
            $order->user_id = $user->id;
            $order->product_id = $product->id;
            $order->price = $product->price;
            $order->save();

            $product->download += 1;
            $product->save();

            notify($user, 'PURCHASE_PRODUCT', [
                'trx' => $trx->trx,
                'amount' => showAmount($product->price),
                'currency' => gs('cur_text'),
                'post_balance' => showAmount($user->balance),
                'product' => $product->name
            ]);

            $notify[] = ['success', 'Successfully purchased, You can download your product from here.'];
            return to_route('user.download.index')->withNotify($notify);
        } else {
            $notify[] = ['error', 'Insufficient balance. Deposit balance from here!'];
            return to_route('user.deposit.index')->withNotify($notify);
        }
    }

    private function handleProductDownload($user, $product)
    {
        if ($product->type == Status::PRODUCT_FREE && $product->price == 0) {
            return $this->handleFreeProduct($user, $product);
        } elseif ($product->type == Status::PRODUCT_PAID && $product->price > 0) {
            return $this->handlePaidProduct($user, $product);
        } else {
            $notify[] = ['error', 'Something went wrong.'];
            return to_route('home')->withNotify($notify);
        }
    }


    public function getDownload($key)
    {

        $id = decrypt($key);
        $product = Product::findOrFail($id);
        $file = $product->file;
        $fileName = getFilePath('productFile') . '/' . $file;
        return  response()->download($fileName);
    }

    public function rating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|gt:0|max:5',
            'product_id' => 'required|integer|gt:0',
            'review' => 'required',
        ]);

        $product = Download::where('product_id', $request->product_id)->where('user_id', auth()->user()->id)->first();

        if ($product == null) {
            $notify[] = ['error', 'Something goes wrong'];
            return back()->withNotify($notify);
        }

        $rating = new Rating();
        $rating->product_id = $request->product_id;
        $rating->user_id = auth()->user()->id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->save();

        $totalRatingProduct = $product->product->total_rating + $request->rating;
        $totalResponseProduct = $product->product->total_response + 1;
        $avgRatingProduct = round($totalRatingProduct / $totalResponseProduct);

        $product->product->total_rating = $totalRatingProduct;
        $product->product->total_response = $totalResponseProduct;
        $product->product->avg_rating = $avgRatingProduct;
        $product->product->save();

        $notify[] = ['success', 'Thanks for your review'];
        return back()->withNotify($notify);
    }
}
