@extends('layouts.app')

@section('title', 'VOGUE — Home')

@push('styles')
<style>
    body { font-family: 'Poppins', sans-serif; margin:0; padding:0; background:#f4f4f4; }

    .home-container { max-width:1200px; margin:2rem auto; padding:0 1rem; display:flex; flex-direction:column; gap:2rem; }

    /* Banner Section */
    .banner-container { position: relative; width: 100%; overflow: hidden; border-radius:12px; }
    .banners-row { display: flex; gap: 1rem; overflow-x: auto; scroll-behavior: smooth; scroll-snap-type: x mandatory; }
    .banners-row::-webkit-scrollbar { display: none; }
    .banners-row a { flex: 0 0 100%; scroll-snap-align: center; display: block; border-radius: 12px; overflow: hidden; transition: transform 0.3s ease; }
    .banners-row a img, .banners-row a video { width: 100%; height: 400px; object-fit: cover; display: block; border-radius: 12px; }
    .banners-row a:hover { transform: scale(1.02); }

    .arrow { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(10, 25, 49, 0.8); color: #fff; border: none; font-size: 2rem; padding: 0.5rem 1rem; cursor: pointer; border-radius: 50%; z-index: 10; transition: background 0.3s ease; }
    .arrow:hover { background: #4a9ca7ff; }
    .left-arrow { left: 10px; }
    .right-arrow { right: 10px; }

    /* Poster Section */
    .poster-section {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .poster-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    .poster-card:hover { transform: translateY(-5px); }

    .poster-wrapper { position: relative; }
    .poster-wrapper img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        display: block;
        border-bottom: 1px solid #eee;
    }

    .vogue-watermark {
        position: absolute;
        top: 12px;
        right: 15px;
        font-size: 22px;
        font-weight: bold;
        color: rgba(255,255,255,0.7);
        text-shadow: 0 0 6px rgba(0,0,0,0.4);
        opacity: 0.9;
    }

    .poster-text {
        padding: 10px 5px 18px;
        font-size: 0.95rem;
        color: #333;
        line-height: 1.5;
    }
</style>
@endpush

@section('content')
<div class="home-container">
    <!-- Dynamic Banners -->
    <div class="banner-container">
        <button class="arrow left-arrow" onclick="scrollBanners(-1)">&#10094;</button>
        <div class="banners-row" id="bannersRow">
            @forelse($media as $m)
                <a href="{{ route('products.index') }}">
                    @if($m->media_type === 'image')
                        <img src="{{ asset($m->file_path) }}" alt="{{ $m->file_name }}">
                    @elseif($m->media_type === 'video')
                        <video autoplay muted loop playsinline>
                            <source src="{{ asset($m->file_path) }}" type="video/mp4">
                        </video>
                    @endif
                </a>
            @empty
                <p style="text-align:center; color:gray; width:100%; padding:50px;">No banners uploaded yet.</p>
            @endforelse
        </div>
        <button class="arrow right-arrow" onclick="scrollBanners(1)">&#10095;</button>
    </div>

    <!-- Poster Section -->
    <div class="poster-section">
        @foreach($posters as $poster)
            <a href="{{ $poster['link'] }}" class="poster-card">
                <div class="poster-wrapper">
                    <img src="{{ asset($poster['file']) }}" alt="Poster">
                    <div class="vogue-watermark">VOGUE</div>
                </div>
                <div class="poster-text">{{ $poster['line1'] }}<br>{{ $poster['line2'] }}</div>
            </a>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
function scrollBanners(direction) {
    const container = document.getElementById('bannersRow');
    const scrollAmount = container.offsetWidth;
    container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
}

// Auto-scroll banners
setInterval(() => scrollBanners(1), 5000);
</script>
@endpush
