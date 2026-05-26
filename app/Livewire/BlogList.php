<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BlogList extends Component
{
    use WithPagination;

    #[Url(as: 'search', except: '')]
    public string $search = '';

    #[Url(as: 'category', except: '')]
    public string $category = '';

    #[Url(as: 'sort', except: 'newest')]
    public string $sortBy = 'newest';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->sortBy = 'newest';
        $this->resetPage();
    }

    public function hasActiveFilters(): bool
    {
        return $this->search !== '' || $this->category !== '';
    }

    public function render(): View
    {
        $categories = PostCategory::whereHas('posts', fn ($q) => $q
            ->where('status', 'published')
            ->where('published_at', '<=', now())
        )->get();

        $posts = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->when($this->search, fn ($q) => $q->where(fn ($q) => $q
                ->where('title', 'like', "%{$this->search}%")
                ->orWhere('excerpt', 'like', "%{$this->search}%")
                ->orWhere('content', 'like', "%{$this->search}%")
            ))
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($q) => $q->where('slug', $this->category)))
            ->when($this->sortBy === 'oldest', fn ($q) => $q->orderBy('published_at'), fn ($q) => $q->orderByDesc('published_at'))
            ->paginate(9);

        return view('livewire.blog-list', compact('posts', 'categories'));
    }
}
