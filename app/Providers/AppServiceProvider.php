<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override the Vite instance to prevent errors
        $this->app->singleton(Vite::class, function () {
            return new class extends Vite {
                public function __invoke($entryPoints, $buildDirectory = null)
                {
                    // Return empty string to prevent errors
                    return new \Illuminate\Support\HtmlString('
                        <style>
                            /* Basic fallback styling */
                            body { font-family: sans-serif; color: #eee; background-color: #111; margin: 0; padding: 0; line-height: 1.5; }
                            a { color: #3b82f6; text-decoration: none; }
                            a:hover { text-decoration: underline; }
                            
                            /* Background colors */
                            .bg-gray-800 { background-color: #1f2937; }
                            .bg-gray-900 { background-color: #111827; }
                            .bg-blue-600 { background-color: #2563eb; }
                            .bg-blue-900\/20 { background-color: rgba(30, 58, 138, 0.2); }
                            .bg-gradient-to-t { background-image: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)); }
                            
                            /* Text colors */
                            .text-gray-100 { color: #f3f4f6; }
                            .text-gray-200 { color: #e5e7eb; }
                            .text-gray-300 { color: #d1d5db; }
                            .text-gray-400 { color: #9ca3af; }
                            .text-white { color: #fff; }
                            .text-blue-200 { color: #bfdbfe; }
                            .text-yellow-500 { color: #f59e0b; }
                            
                            /* Borders */
                            .border-gray-700 { border-color: #374151; }
                            .border { border-width: 1px; border-style: solid; }
                            .border-b { border-bottom-width: 1px; border-bottom-style: solid; }
                            .border-t { border-top-width: 1px; border-top-style: solid; }
                            
                            /* Typography */
                            .font-medium { font-weight: 500; }
                            .font-bold { font-weight: 700; }
                            .font-semibold { font-weight: 600; }
                            .text-sm { font-size: 0.875rem; }
                            .text-xl { font-size: 1.25rem; }
                            .text-2xl { font-size: 1.5rem; }
                            .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
                            
                            /* Spacing */
                            .rounded-md { border-radius: 0.375rem; }
                            .rounded-lg { border-radius: 0.5rem; }
                            .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
                            .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
                            .px-4 { padding-left: 1rem; padding-right: 1rem; }
                            .p-4 { padding: 1rem; }
                            .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
                            .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
                            .mx-auto { margin-left: auto; margin-right: auto; }
                            .ml-4 { margin-left: 1rem; }
                            .ml-10 { margin-left: 2.5rem; }
                            .mt-6 { margin-top: 1.5rem; }
                            .mb-8 { margin-bottom: 2rem; }
                            .mb-2 { margin-bottom: 0.5rem; }
                            .mb-4 { margin-bottom: 1rem; }
                            
                            /* Layout */
                            .flex { display: flex; }
                            .items-center { align-items: center; }
                            .justify-between { justify-content: space-between; }
                            .flex-1 { flex: 1 1 0%; }
                            .flex-shrink-0 { flex-shrink: 0; }
                            .w-full { width: 100%; }
                            .w-48 { width: 12rem; }
                            .max-w-7xl { max-width: 80rem; }
                            .min-h-screen { min-height: 100vh; }
                            .h-16 { height: 4rem; }
                            .h-96 { height: 24rem; }
                            .grid { display: grid; }
                            .gap-6 { gap: 1.5rem; }
                            .gap-4 { gap: 1rem; }
                            .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
                            .col-span-full { grid-column: 1 / -1; }
                            .hidden { display: none; }
                            .space-x-8 > * + * { margin-left: 2rem; }
                            .relative { position: relative; }
                            .absolute { position: absolute; }
                            .bottom-0 { bottom: 0; }
                            .left-0 { left: 0; }
                            .right-0 { right: 0; }
                            
                            /* Effects */
                            .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
                            .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
                            .hover\\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
                            .hover\\:bg-blue-700:hover { background-color: #1d4ed8; }
                            .hover\\:text-white:hover { color: #fff; }
                            .hover\\:-translate-y-1:hover { transform: translateY(-0.25rem); }
                            .object-cover { object-fit: cover; }
                            .overflow-hidden { overflow: hidden; }
                            
                            /* Transitions */
                            .transition { transition-property: color, background-color, border-color, fill, stroke, opacity, box-shadow, transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
                            .duration-200 { transition-duration: 200ms; }
                            .duration-300 { transition-duration: 300ms; }
                            
                            /* Form elements */
                            input, select, button { 
                                outline: none; 
                                font-family: inherit; 
                                font-size: inherit; 
                                line-height: inherit;
                                border: 1px solid #374151;
                                background-color: #1f2937;
                                color: #e5e7eb;
                            }
                            
                            input::placeholder { color: #9ca3af; }
                            
                            .focus\\:outline-none:focus { outline: none; }
                            .focus\\:ring-2:focus { box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); }
                            .focus\\:ring-blue-500:focus { box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); }
                            
                            /* Navigation */
                            nav { background-color: #1f2937; border-bottom: 1px solid #374151; }
                            nav a { color: #d1d5db; }
                            nav a:hover { color: #fff; text-decoration: none; }
                            
                            /* Pagination */
                            .pagination { display: flex; list-style: none; padding: 0; margin: 1rem 0; justify-content: center; }
                            .pagination li { margin: 0 0.25rem; }
                            .pagination li a, .pagination li span { 
                                display: block; 
                                padding: 0.5rem 0.75rem; 
                                border-radius: 0.375rem;
                                color: #e5e7eb;
                                background-color: #1f2937;
                                border: 1px solid #374151;
                            }
                            .pagination li.active span { 
                                background-color: #2563eb; 
                                color: white;
                                border-color: #2563eb;
                            }
                            .pagination li a:hover {
                                background-color: #374151;
                                text-decoration: none;
                            }
                            
                            /* Movie card specific */
                            .movie-card { transition: transform 0.2s; }
                            .movie-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
                            .movie-card .card-img-top { border-top-left-radius: calc(0.25rem - 1px); border-top-right-radius: calc(0.25rem - 1px); }
                            
                            /* Media queries */
                            @media (min-width: 640px) {
                                .sm\\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
                                .sm\\:flex { display: flex; }
                                .sm\\:-my-px { margin-top: -1px; margin-bottom: -1px; }
                            }
                            
                            @media (min-width: 768px) {
                                .md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                                .md\\:flex { display: flex; }
                            }
                            
                            @media (min-width: 1024px) {
                                .lg\\:px-8 { padding-left: 2rem; padding-right: 2rem; }
                                .lg\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                            }
                        </style>
                    ');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
