<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Site Navigation (Tailwind Plus Ecommerce header) -->
        <!-- Mobile menu -->
        <el-dialog>
            <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
                <el-dialog-backdrop class="fixed inset-0 bg-black/25 transition-opacity duration-300 ease-linear data-closed:opacity-0"></el-dialog-backdrop>
                <div tabindex="0" class="fixed inset-0 flex focus:outline-none">
                    <el-dialog-panel class="relative flex w-full max-w-xs transform flex-col overflow-y-auto bg-white pb-12 shadow-xl transition duration-300 ease-in-out data-closed:-translate-x-full">
                        <div class="flex px-4 pt-5 pb-2">
                            <button type="button" command="close" commandfor="mobile-menu" class="relative -m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Close menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <!-- Links (mobile) -->
                        <el-tab-group class="mt-2 block">
                            <div class="border-b border-gray-200">
                                <el-tab-list class="-mb-px flex space-x-8 px-4">
                                    <button class="flex-1 border-b-2 border-transparent px-1 py-4 text-base font-medium whitespace-nowrap text-gray-900 aria-selected:border-indigo-600 aria-selected:text-indigo-600" onclick="window.location='/products?category=women'">Women</button>
                                    <button class="flex-1 border-b-2 border-transparent px-1 py-4 text-base font-medium whitespace-nowrap text-gray-900 aria-selected:border-indigo-600 aria-selected:text-indigo-600" onclick="window.location='/products?category=men'">Men</button>
                                </el-tab-list>
                            </div>
                        </el-tab-group>

                        <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                            <div class="flow-root">
                                <a href="/about" class="-m-2 block p-2 font-medium text-gray-900">About us</a>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-6">
                            <a href="/account" class="-m-2 block p-2 font-medium text-gray-900">Account</a>
                            <a href="/cart" class="-m-2 mt-2 block p-2 font-medium text-gray-900">Cart</a>
                        </div>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>

        <header class="relative bg-white border-b">
            <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="border-b border-gray-200">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex flex-1 items-center lg:hidden">
                            <button type="button" command="show-modal" commandfor="mobile-menu" class="-ml-2 rounded-md bg-white p-2 text-gray-400">
                                <span class="sr-only">Open menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <!-- Flyout menus / primary nav -->
                        <el-popover-group class="group/popover-group hidden lg:block lg:flex-1 lg:self-stretch">
                            <div class="flex h-full space-x-8">
                                <div class="group/popover flex">
                                    <div class="relative flex">
                                        <button popovertarget="desktop-menu-women" onclick="window.location='/products?category=women'" class="relative flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out group-not-has-open/popover:text-gray-700 group-has-open/popover:text-indigo-600 group-not-has-open/popover:hover:text-gray-800">
                                            Women
                                            <span aria-hidden="true" class="absolute inset-x-0 -bottom-px z-30 h-0.5 bg-transparent duration-200 ease-in group-has-open/popover:bg-indigo-600 group-has-open/popover-group:duration-150 group-has-open/popover-group:ease-out"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="group/popover flex">
                                    <div class="relative flex">
                                        <button popovertarget="desktop-menu-men" onclick="window.location='/products?category=men'" class="relative flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out group-not-has-open/popover:text-gray-700 group-has-open/popover:text-indigo-600 group-not-has-open/popover:hover:text-gray-800">
                                            Men
                                            <span aria-hidden="true" class="absolute inset-x-0 -bottom-px z-30 h-0.5 bg-transparent duration-200 ease-in group-has-open/popover:bg-indigo-600 group-has-open/popover-group:duration-150 group-has-open/popover-group:ease-out"></span>
                                        </button>
                                    </div>
                                </div>

                                <a href="/about" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">About us</a>
                            </div>
                        </el-popover-group>

                        <!-- Logo -->
                        <a href="/" class="flex">
                            <span class="sr-only">{{ config('app.name', 'Store') }}</span>
                            <img src="/images/logo.png" alt="" class="h-8 w-auto" />
                        </a>

                        <div class="flex flex-1 items-center justify-end">
                            <!-- Account -->
                            <a href="/account" class="p-2 text-gray-400 hover:text-gray-500 lg:ml-4">
                                <span class="sr-only">Account</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                    <path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <!-- Cart -->
                            <div class="ml-4 flow-root lg:ml-6">
                                <a href="/cart" class="group -m-2 flex items-center p-2">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 shrink-0 text-gray-400 group-hover:text-gray-500">
                                        <path d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                    <span class="sr-only">items in cart, view bag</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
