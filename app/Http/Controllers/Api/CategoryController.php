<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Models\View;
use App\Models\Account;
use App\Models\Category;
use App\Models\CategorySubAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\ParentCategoryResource;

class CategoryController extends Controller
{

    // to get all categories with thier subs
    // public function allCategories()
    // {

    //     if (Auth::guard('api')->check())
    //     {

    //         $user = User::find(Auth::guard('api')->user()->id);
    //         if( !$user )
    //         {
    //             return sendJsonError('user not exist');
    //         }else
    //         {
    //             // dd('aaaaaaaa');

    //             $data = file_get_contents(base_path('/public/cats.json'));

    //             $data = json_decode($data, true);
    //             return response($data);
    //             return $data;

    //             // $data = json_decode($data, true);

    //             // $sub_accounts_user_id = $user->subAccounts()->pluck('sub_account_id');
    //             // $sub_accounts_category_id = CategorySubAccount::whereIn( 'sub_account_id', $sub_accounts_user_id )->pluck('category_id');
    //             // $categories = Category::where('parent_id', 0)->with('childrenRecursive')->whereIn( 'id', $sub_accounts_category_id )->get();

    //             // return sendJsonResponse(CategoryResource::collection($categories),'all categories with thier sub');
    //         }
    //     }else
    //     {
    //         // dd('aaaaaaaa');
    //         $data = file_get_contents(base_path('/public/cats.json'));
    //         $data = json_decode($data, true);
    //         return response($data);
    //         // $data = json_decode($data, true);

    //         // $categories = Category::where('parent_id', 0)->with(['childrenRecursive'])->get();
    //         // return sendJsonResponse(CategoryResource::collection($categories),'all categories with thier sub');
    //     }
    // }

    // Mohamed Gharib
    // public function allCategories()
    // {
    //     if (Auth::guard('api')->check()) {

    //         $user = User::find(Auth::guard('api')->user()->id);
    //         if (!$user) {
    //             return sendJsonError('user not exist');
    //         } else {
    //             $categories = Cache::rememberForever('categories', function () {
    //                 $sub_accounts_user_id = $user->subAccounts()->pluck('sub_account_id');
    //                 $sub_accounts_category_id = CategorySubAccount::whereIn('sub_account_id', $sub_accounts_user_id)->pluck('category_id');
    //                 $categories =  Category::where('parent_id', 0)->with('childrenRecursive')->whereIn('id', $sub_accounts_category_id)->get();
    //               return CategoryResource::collection($categories);
    //             });

    //             return sendJsonResponse(CategoryResource::collection($categories), 'all categories with thier sub');
    //         }
    //     } else {
    //             //  $categories = Category::where('parent_id', 0)->with(['childrenRecursive'])->get();
    //         $categoriess = Cache::rememberForever('categories', function () {
    //              $categories = Category::where('parent_id', 0)->with(['childrenRecursive'])->get();
    //         });
    //             //  return($categoriess);
    //         return sendJsonResponse($categoriess , 'all categories with thier sub');
    //     }
    // }

    // to get all parents
    /**
     * @param $tab
     */
    public function ParentCategories($tab = null)
    {
        // dd(Auth::guard('api')->user());

        if (Auth::guard('api')->check()) {

            // $user = User::find(Auth::guard('api')->user()->id);

            // if( !$user )
            // {
            //     return sendJsonError('user not exist');
            // }

            //without cat_id but with user_id and tab
            if ($tab != null) {
                // tab = 'personal'
                if ($tab == 1) {

                    //   $categories = SubAccount::where('name',  'like','%' . 'personal' . '%')->first()->categories()->with('view')->where('parent_id', 0)->orderby('position')->get();

                    $categories = Category::whereHas('subAccounts', function ($q) {
                        $q->where('name', 'personal');
                    })->with(['parents', 'view'])
                      ->withCount([
                          'products',
                      ])->where('parent_id', 0)

                      ->withMin('products', 'price')
                      ->withMax('products', 'price')
                      ->orderby('position')->get();

                    $data = [

                        'all'        => null,
                        'categories' => ParentCategoryResource::collection($categories),

                    ];

                // tab = 'company'
                } else {
                    $account = Account::where('name', 'like', '%' . 'company' . '%')->first();

                    if ($account) {
                        $sub_accounts_user_id = $user->subAccounts()->where('account_id', $account->id)->pluck('sub_account_id');
                        $sub_accounts_category_id = CategorySubAccount::whereIn('sub_account_id', $sub_accounts_user_id)->pluck('category_id');
                        $categories = Category::where('parent_id', 0)->with(['parents', 'view'])
                                                                     ->withCount([
                                                                         'products',
                                                                     ])->where('parent_id', 0)

                                                                     ->withMin('products', 'price')
                                                                     ->withMax('products', 'price')
                                                                     ->whereIn('id', $sub_accounts_category_id)->orderby('position')->get();
                        $data = [

                            'all'        => null,
                            'categories' => ParentCategoryResource::collection($categories),

                        ];
                    }
                }

                //just with user_id
            } else {
                // $sub_accounts_user_id = $user->subAccounts()->pluck('sub_account_id');
                // $sub_accounts_category_id = CategorySubAccount::whereIn( 'sub_account_id', $sub_accounts_user_id )->pluck('category_id');
                $categories = Category::where('parent_id', 0)->orderby('position')->with(['parents', 'view'])
                                                             ->withCount([
                                                                 'products',
                                                             ])->where('parent_id', 0)

                                                             ->withMin('products', 'price')
                                                             ->withMax('products', 'price')
                                                             ->get();
                $data = [

                    'all'        => null,
                    'categories' => ParentCategoryResource::collection($categories),

                ];
            }

            // without user_id and tab
        } else {
            $categories = Category::where('parent_id', 0)->with(['parents', 'view'])
                                                         ->withCount([
                                                             'products',
                                                         ])->where('parent_id', 0)

                                                         ->withMin('products', 'price')
                                                         ->withMax('products', 'price')
                                                         ->orderby('position')->get();
            $data = [

                'all'        => null,
                'categories' => ParentCategoryResource::collection($categories),

            ];
        }
        return sendJsonResponse(ParentCategoryResource::collection($categories), 'parent categories');
    }

    /**
     * @param $cat_id
     * @param null      $tab
     */
    public function SubCategories($cat_id = null, $tab = null)
    {
        if ($cat_id == null) {
            return sendJsonError('Category id is requird');
        }

        request()->query->set('banner_id', optional(View::where('name', 'banner')->first())->id);

        if (Auth::guard('api')->check()) {
            // dd('auth');

            $user = User::findOrFail(Auth::guard('api')->user()->id);

            if (!$user) {
                return sendJsonError('user not exist');
            }
            //without cat_id but with user_id and tab
            if ($tab != null) {
                // dd('tab');
                // tab = 'personal'
                if ($tab == 1) {

                    // $categories = SubAccount::where('name', 'personal')->first();
                    // $categories = $categories->categories()->where('parent_id', $cat_id)->with('view')->orderby('position')->get();

                    $categories = Category::where('parent_id', $cat_id)->whereHas('subAccounts', function ($q) {
                        $q->where('name', 'personal');
                    })->with('view')->orderby('position')->get();

                    //
                    $data = [

                        'all'        => null,
                        'categories' => SubCategoryResource::collection($categories),
                    ];

                // tab = 'company'
                } else {
                    $account = Account::where('name', 'company')->first();

                    if ($account) {
                        $sub_accounts_user_id = $user->subAccounts()->where('account_id', $account->id)->pluck('sub_account_id');
                        $sub_accounts_category_id = CategorySubAccount::whereIn('sub_account_id', $sub_accounts_user_id)->pluck('category_id');
                        $categories = Category::where('parent_id', $cat_id)->whereIn('id', $sub_accounts_category_id)->orderby('position')->get();

                        //
                        $data = [

                            'all'        => null,
                            'categories' => SubCategoryResource::collection($categories),

                        ];
                    }
                }

                //just with user_id
            } else {
                // $sub_accounts_user_id = $user->subAccounts()->pluck('sub_account_id');
                // $sub_accounts_category_id = CategorySubAccount::whereIn( 'sub_account_id', $sub_accounts_user_id )->pluck('category_id');
                $categories = Category::query()
                    ->where('parent_id', $cat_id)
                    ->with([
                        'parents',
                        'view',
                    ])
                    ->withCount([
                        'products',
                    ])
                    ->withMin('products', 'price')
                    ->withMax('products', 'price')
                    ->orderby('position')
                    ->get();

                $cat_is_all = Category::find($cat_id);
                // dd($cat_is_all->is_all);
                if ($cat_is_all && $cat_is_all->is_all) {
                    $all = array(
                        'id'          => (int) $cat_id,
                        'name'        => 'All',
                        'description' => 'Description to all',
                        'view_name'   => "last_level",
                        'image'       => $cat_is_all->image,
                        'parent_id'   => null,
                        'text_1'      => null,
                        'text_2'      => null,
                    );

                    $data = [

                        'all'        => $all,
                        'categories' => SubCategoryResource::collection($categories),
                    ];
                } else {
                    $data = [

                        'all'        => null,
                        'categories' => SubCategoryResource::collection($categories),

                    ];
                }
            }

            // without user_id and tab
        } else {
            // dd('!auth');
            $categories = Category::query()
                ->where('parent_id', $cat_id)
                ->with([
                    'parents',
                    'view',
                ])
                ->withCount([
                    'products',
                ])
                ->withMin('products', 'price')
                ->withMax('products', 'price')
                ->orderby('position')
                ->get();

            // request();
//

            $data = [

                'all'        => null,
                'categories' => SubCategoryResource::collection($categories),
            ];
        }

        return sendJsonResponse($data, 'Fetched successfully.');
    }
}
