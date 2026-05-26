<x-layouts.app :title="$post->title . ' — TripKuy'">

    <x-partials::blog.hero-section :$post />

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex flex-col gap-8">

        <x-partials::blog.article-content :$post />

        <x-partials::blog.author-card :$post />

    </div>

    <x-partials::blog.related-posts :$relatedPosts />

</x-layouts.app>
