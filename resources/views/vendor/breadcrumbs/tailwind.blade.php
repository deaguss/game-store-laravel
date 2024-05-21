@unless ($breadcrumbs->isEmpty())
<nav class="container mx-auto">
    <ol class="p-4 rounded flex flex-wrap font-medium text-sm text-gray-800">
        @foreach ($breadcrumbs as $breadcrumb)

        @if ($breadcrumb->url && !$loop->last)
        <li>
            <a href="{{ $breadcrumb->url }}"
                class="text-gray-400 hover:text-gray-700 underline underline-offset-2 focus:text-gray-700 focus:underline">
                {{ $breadcrumb->title }}
            </a>
        </li>
        @else
        <li class="text-gray-400 font-bold hover:text-gray-700 focus:text-gray-700">
            {{ $breadcrumb->title }} {{ strtolower($breadcrumb->title) === "admin" ? "/" : "" }}
        </li>
        @endif

        @unless($loop->last)
        <li class="text-gray-400 px-2">
            /
        </li>
        @endif

        @endforeach
    </ol>
</nav>
@endunless
