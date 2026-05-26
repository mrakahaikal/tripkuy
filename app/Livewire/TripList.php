<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Trip;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TripList extends Component
{
    use WithPagination;

    #[Url(as: 'search', except: '')]
    public string $search = '';

    #[Url(as: 'category', except: '')]
    public string $category = '';

    #[Url(as: 'destination', except: '')]
    public string $destination = '';

    #[Url(as: 'date_from', except: '')]
    public string $dateFrom = '';

    #[Url(as: 'date_to', except: '')]
    public string $dateTo = '';

    #[Url(as: 'min_price', except: '')]
    public string $minPrice = '';

    #[Url(as: 'max_price', except: '')]
    public string $maxPrice = '';

    /** @var array<string> */
    #[Url(as: 'difficulty', except: [])]
    public array $difficulty = [];

    /** @var array<string> */
    #[Url(as: 'duration', except: [])]
    public array $duration = [];

    #[Url(as: 'sort', except: 'popular')]
    public string $sortBy = 'popular';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedDestination(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatedMaxPrice(): void
    {
        $this->resetPage();
    }

    public function updatedDifficulty(): void
    {
        $this->resetPage();
    }

    public function updatedDuration(): void
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
        $this->destination = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->difficulty = [];
        $this->duration = [];
        $this->sortBy = 'popular';
        $this->resetPage();
    }

    public function hasActiveFilters(): bool
    {
        return $this->search !== ''
            || $this->category !== ''
            || $this->destination !== ''
            || $this->dateFrom !== ''
            || $this->dateTo !== ''
            || $this->minPrice !== ''
            || $this->maxPrice !== ''
            || $this->difficulty !== []
            || $this->duration !== [];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $categories = Category::whereHas('trips', fn ($q) => $q->where('status', 'published'))
            ->withCount(['trips' => fn ($q) => $q->where('status', 'published')])
            ->get();

        $trips = Trip::query()
            ->where('status', 'published')
            ->with(['category'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('destination', 'like', "%{$this->search}%")
                        ->orWhere('highlight', 'like', "%{$this->search}%");
                });
            })
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($q) => $q->where('slug', $this->category)))
            ->when($this->destination, fn ($q) => $q->where('destination', 'like', "%{$this->destination}%"))
            ->when($this->dateFrom, fn ($q) => $q->where('start_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->where('start_date', '<=', $this->dateTo))
            ->when($this->minPrice !== '', fn ($q) => $q->where('price', '>=', (int) $this->minPrice))
            ->when($this->maxPrice !== '', fn ($q) => $q->where('price', '<=', (int) $this->maxPrice))
            ->when($this->difficulty, fn ($q) => $q->whereIn('difficulty_level', $this->difficulty))
            ->when($this->duration, function ($q) {
                $q->where(function ($q) {
                    foreach ($this->duration as $range) {
                        match ($range) {
                            '1-3' => $q->orWhereBetween('duration_days', [1, 3]),
                            '4-7' => $q->orWhereBetween('duration_days', [4, 7]),
                            '8+'  => $q->orWhere('duration_days', '>=', 8),
                            default => null,
                        };
                    }
                });
            })
            ->when($this->sortBy, function ($q) {
                match ($this->sortBy) {
                    'newest'     => $q->orderByDesc('created_at'),
                    'price_asc'  => $q->orderBy('price'),
                    'price_desc' => $q->orderByDesc('price'),
                    default      => $q->orderByDesc('reviews_avg_rating')->orderByDesc('reviews_count'),
                };
            })
            ->paginate(12);

        return view('livewire.trip-list', compact('trips', 'categories'));
    }
}
