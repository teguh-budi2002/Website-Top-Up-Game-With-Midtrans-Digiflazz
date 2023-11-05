<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Notification;
use App\Models\PaymentFee;
use App\Models\PaymentGatewayProvider;
use App\Models\Product;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Product\ProductRepository;

class DashboardController extends Controller
{
    protected $provider;

    public function __construct()
    {
      $this->provider = DB::table('payment_gateway_providers')
                          ->select("id", "payment_name")
                          ->where('status', 1)
                          ->first();
    }
    public function index() {
      return view('dashboard.views.main');
    }

    public function manage_website(Request $request) {
      $getNameAndSlugProduct = DB::table('products')->select("id", "product_name", 'slug')->paginate(8);
      $getCustomFields = DB::table('custom_fields')
                            ->select("id", "text_title_on_order_page", "description_on_order_page", "bg_img_on_order_page", "detail_for_product", "page_slug", "has_zone_id")
                            ->where('page_slug', $request->query('slug'))
                            ->get();
      return view('dashboard.views.manage_website.main', [
        'products' => $getNameAndSlugProduct,
        'oldCustomFields' => $getCustomFields
      ]);
    }

    public function manage_product_pages(Request $request) {

      if ($request->has('search_product')) {
        $getProduct = ProductRepository::searchProduct($request->get('search_product'));
        $getProduct->appends(['search_product' => $request->get('search_product')]);
      } else {
        if ($request->query('category_id')) {
            $category_id = $request->query('category_id');

            $getProduct = Product::with(['items', 'category:id,name_category', 'paymentMethods:id,img_static,payment_name'])->where('category_id', $category_id)->paginate(10);
        } else {
          $getProduct = Product::with(['items', 'category:id,name_category', 'paymentMethods:id,img_static,payment_name'])->paginate(10);
        }
      }

      $categoryProduct = CategoryProduct::select("id", "name_category")->get();
      return view('dashboard.views.manage_product.main', [
        'products' => $getProduct,
        'categories'  => $categoryProduct
      ]);

    }

    public function manage_payment_product() {
      $provider = $this->provider; 
      if (!empty($provider)) {
        $providerName = $provider->payment_name;
        $paymentMethods = DB::table("payment_methods")
                                    ->select("id", "payment_name", "type_of_payment", "img_static", "provider")
                                    ->where('provider', $provider->payment_name)
                                    ->groupBy("id", "payment_name", "type_of_payment", "img_static", "provider")
                                    ->get();
        $getProducts = Product::with('paymentMethods')->select("id", "product_name", "published")->paginate(8);
  
        return view ('dashboard.views.manage_payment_product.main', [
          'provider_name'   => $providerName,
          'payment_methods' => $paymentMethods,
          'products' => $getProducts
        ]);
      } else {
        return view ('dashboard.views.manage_payment_product.main', [
          'payment_methods' => null
        ]);
      }
    }

    public function manage_payment_fee() {
      $provider = $this->provider; 
      if (!empty($provider)) {
        $getAllPayments = DB::table("payment_methods")
                              ->select("id", "payment_name", "img_static")
                              ->where('provider', $provider->payment_name)
                              ->get();
        $getPaymentIncludeFees = PaymentFee::with('payment:id,payment_name,img_static')->get();
        return view('dashboard.views.manage_payment_fee.main', [
          'payment_methods' => $getAllPayments,
          'payment_fees' => $getPaymentIncludeFees
        ]);
      } else {
         return view('dashboard.views.manage_payment_fee.main', [
          'payment_methods' => null,
        ]);
      }
    }

    public function manage_discount() {
      return view('dashboard.views.manage_discount.main');;
    }

    public function list_product_discount() {
      $itemDiscount         = DB::table('discount_products')
                                  ->join('items', 'discount_products.item_id', '=', 'items.id')
                                  ->join('products', 'discount_products.product_id', '=', 'products.id')
                                  ->select('discount_products.*', 'items.*', 'products.id', 'products.product_name')
                                  ->paginate(5);
      $flashSales           = DB::table('flash_sales')
                                  ->select("id", "name_flashsale", "is_flash_sale", "start_time", "end_time")
                                  ->get();
      $itemAddedOnFlashsale = DB::table('flashsale_discount_items')
                                  ->select("id", "item_id")
                                  ->get();
      return view('dashboard.views.manage_discount.list_discount', [
        'items_discount' => $itemDiscount,
        'flash_sales'    => $flashSales,
        'items_on_flashsale' => $itemAddedOnFlashsale
      ]);
    }

    public function manage_seo_website() {
      $getDataSeo = DB::table('seo_website')
                        ->select('id', 'name_of_the_company', 'keyword', 'description', 'logo_favicon', 'logo_website')
                        ->first();

      return view('dashboard.views.manage_seo.main', [
        'data_seo' => $getDataSeo
      ]);
    }

    public function manage_payment_gateway(Request $request) {
      $paymentGateway = DB::table('payment_gateway_providers')
                            ->select('id', 'payment_name', 'client_key', 'server_key', 'status')
                            ->paginate(3);
      $oldPg = null;
      if ($request->has('pg_name')) {
        $oldPg = DB::table('payment_gateway_providers')
                    ->select('id', 'payment_name', 'client_key', 'server_key', 'status')
                    ->where('payment_name', $request->query('pg_name'))
                    ->first();
      }
      
      return view('dashboard.views.manage_payment_gateway.main', [
        'payment_gateway' => $paymentGateway,
        'old_payment_gateway' => $oldPg
      ]);
    }

    public function manage_notification(Request $request) {
      $notifications = DB::table('notifications')
                        ->select("id", "notif_title", "notif_slug", "notif_description", "type_notif", "notif_img")
                        ->paginate(5);
                        
      $oldNotification = DB::table('notifications')
                            ->select("id", "notif_title", "notif_slug", "notif_description", "type_notif", "notif_img")
                            ->where('notif_slug', $request->query('notif_slug'))
                            ->first();
                            
      return view("dashboard.views.manage_notification.main", [
        'notifications' => $notifications,
        'old_notification' =>  $oldNotification
      ]);
    }

    public function manage_provider(Request $request) {
      $providers = DB::table('providers')
                      ->select('id', 'provider_name', 'username', 'key', 'status')
                      ->paginate(5);
      $oldProvider = null;
      if ($request->query('provider_name')) {
        $oldProvider = DB::table('providers')
                      ->select('id', 'provider_name', 'username', 'key', 'status')
                      ->where('provider_name', $request->query('provider_name'))
                      ->first();
      } 
      return view('dashboard.views.manage_provider.main', [ 
        'providers' => $providers,
        'oldProvider' => $oldProvider 
      ]);
    }

    public function manage_social_media() {
      $socialMedia = DB::table('social_media')
                        ->select('id', 'instagram', 'whatsapp', 'email', 'facebook')
                        ->first(); 
      return view('dashboard.views.manage_social_media.main', [
        'social_media' => $socialMedia
      ]);
    }

    public function manage_user(Request $request) {
      $columnMap = [
          'online_user' => 'status_online',
          'offline_user' => 'status_online',
          'active_user' => 'status_active',
          'deactive_user' => 'status_active',
      ];

      $getAllUsers = User::select('id', 'fullname', 'email', 'phone_number', 'username', 'ip_user', 'status_active', 'status_online', 'last_seen', 'role_id', 'created_at')
                          ->when($request->has('role_id'), function ($query) use ($request) { 
                              $query->where('role_id', $request->query('role_id'));
                          })
                          ->when($request->input('search_user'), function ($query) use ($request) {
                              $query->where('fullname', 'LIKE', '%' . $request->input('search_user') . '%')
                                    ->orWhere('username', 'LIKE', '%' . $request->input('search_user') . '%');
                          })
                          ->when($request->has('filter-by'), function ($query) use ($columnMap, $request) { 
                             if (isset($columnMap[$request->query('filter-by')])) {
                                  $query->where($columnMap[$request->query('filter-by')], ($request->query('filter-by') === 'online_user' || $request->query('filter-by') === 'active_user') ? 1 : 0);
                              }
                          })
                          ->with('role:id,role_name')
                          ->paginate(20);

                          $getRoleNames = RoleUser::select('id', 'role_name')->get();
      return view('dashboard.views.manage_user.main', [
        'users' => $getAllUsers,
        'roles' => $getRoleNames
      ]);
    }
}
