<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreOrderRequest;
use App\Services\Midtrans\CreateSnapTokenService;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $interface){
      $this->orderRepository = $interface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::with('items')->first();
        return view('welcome', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validation = $request->validated();
        DB::beginTransaction();
        try {
          $checkout = $this->orderRepository->checkout($request->all());
          DB::commit();
          return redirect()->back()->with('checkout_success', 'Checkout Berhasil Ditambahkan, Silahkan Lakukan Pembayaran.');
        } catch (\Throwable $th) {
          DB::rollback();
          return redirect()->back()->with("checkout_error", 'Checkout Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
      $snapToken = $order->snap_token;
      // Checking Snap Token User
      if (is_null($snapToken)) {
          $createSnapToken = $this->orderRepository->getSnapToken($order);
          // Save Token Into DB
          $order->snap_token = $createSnapToken;
          $order->save();
      }

      return view('payment_page', [
        'order' => $order->with('product')->first(),
        'snapToken' => $snapToken
      ]);
    }
}
