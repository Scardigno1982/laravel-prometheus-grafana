<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>

    <a href="masda.sin"><h1 class="text-3xl text-center text-gray-800 leading-9 font-bold tracking-tight sm:text-4xl sm:leading-10 mb-10 mt-10">Latest Posts</h1></a>
</x-app-layout>
