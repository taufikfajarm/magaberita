<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\ArticleNews;
use Illuminate\Http\Request;
use App\Models\BannerAdvertisement;

class FrontController extends Controller
{
    //
    public function index(){
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(3)
        ->get();

        $featured_articles = ArticleNews::with(['category'])
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->take(3)
        ->get();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        $authors = Author::all();

        $entertainment_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $entertainment_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        $technology_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Technology');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $technology_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Technology');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        $politic_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Politic');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $politic_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Politic');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        return view('front.index', compact('categories', 'articles', 'authors', 'featured_articles', 'bannerads', 'entertainment_articles', 'entertainment_featured_articles', 'technology_articles', 'technology_featured_articles', 'politic_articles', 'politic_featured_articles'));
    }

    public function category(Category $category) {
        $categories = Category::all();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        return view('front.category', compact('category', 'categories', 'bannerads'));
    }

    public function author(Author $author) {
        $categories = Category::all();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        return view('front.author', compact('categories', 'author', 'bannerads'));
    }

    public function search(Request $request){

        $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $categories = Category::all();

        $keyword = $request->keyword;

        $articles = ArticleNews::with(['category', 'author'])
        ->where('name', 'like', '%' . $keyword . '%')->paginate(6);

        return view('front.search', compact('articles', 'keyword', 'categories'));
    }

    public function details(ArticleNews $articleNews){
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
        ->where('is_featured', 'not_featured')
        ->where('id', '!=', 'articleNews->id')
        ->latest()
        ->take(3)
        ->get();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        $square_ads = BannerAdvertisement::where('type', 'square')
            ->where('is_active', 'active')
            ->inRandomOrder()
            ->take(2)
            ->get();

        if ($square_ads->count() < 2) {
            $square_ads_1 = $square_ads->first();
            $square_ads_2 = $square_ads->first();
        } else {
            $square_ads_1 = $square_ads->get(0);
            $square_ads_2 = $square_ads->get(1);
        }

        $author_news = ArticleNews::where('author_id', $articleNews->author_id)
        ->where('id', '!=', $articleNews->id)
        ->inRandomOrder()->get();



        return view('front.details', compact('articleNews', 'categories', 'articles', 'bannerads', 'square_ads_1', 'square_ads_2', 'author_news'));
    }

}
