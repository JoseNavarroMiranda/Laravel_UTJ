@extends('vistasbase.body')

@section('title', 'Producto: ' . $producto->nombre_producto)
@section('page_header', 'Detalle del producto')

@section('content')
    @includeIf('vistasbase.navbar')

    <section class="producto-detalle-wrapper">
        <div class="producto-detalle-card card shadow-sm">
            <div class="row g-0 flex-md-row">
                <div class="col-lg-5">
                    <div class="producto-detalle-media h-100">
                        @php
                            $slides = collect();
                            if (!empty($producto->imagen_producto)) {
                                $slides->push([
                                    'tipo' => 'imagen',
                                    'src' => asset('images/' . $producto->imagen_producto),
                                    'alt' => $producto->nombre_producto . ' - imagen principal',
                                    'duracion' => 5000,
                                ]);
                            }
                            if (!empty($producto->video_producto)) {
                                $videoRuta = asset('videos/' . $producto->video_producto);
                                $extension = strtolower(pathinfo($producto->video_producto, PATHINFO_EXTENSION));
                                $esImagenAnimada = in_array($extension, ['gif', 'jpg', 'jpeg', 'png', 'webp']);
                                $slides->push([
                                    'tipo' => $esImagenAnimada ? 'imagen' : 'video',
                                    'src' => $videoRuta,
                                    'alt' => $producto->nombre_producto . ' - ' . ($esImagenAnimada ? 'animacion' : 'video'),
                                    'duracion' => $esImagenAnimada ? 100 : null,
                                ]);
                            }
                        @endphp

                        @if ($slides->isNotEmpty())
                            <div class="producto-slider" data-interval="5000">
                                <div class="producto-slider-track">
                                    @foreach ($slides as $index => $slide)
                                        <div class="producto-slide {{ $index === 0 ? 'is-active' : '' }}"
                                            data-slide-index="{{ $index }}"
                                            data-slide-type="{{ $slide['tipo'] }}"
                                            data-slide-duration="{{ $slide['duracion'] ?? '' }}">
                                            @if ($slide['tipo'] === 'video')
                                                <video src="{{ $slide['src'] }}" controls muted playsinline
                                                    class="producto-detalle-video-slide">
                                                </video>
                                            @else
                                                <img src="{{ $slide['src'] }}" class="producto-detalle-imagen d-block w-100"
                                                    alt="{{ $slide['alt'] }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                @if ($slides->count() > 1)
                                    <div class="producto-slider-controls">
                                        <button type="button" class="producto-slider-control prev" aria-label="Anterior">‹</button>
                                        <button type="button" class="producto-slider-control next" aria-label="Siguiente">›</button>
                                    </div>
                                    <div class="producto-slider-indicators">
                                        @foreach ($slides as $index => $slide)
                                            <button type="button"
                                                class="producto-slider-indicator {{ $index === 0 ? 'is-active' : '' }}"
                                                data-slide-to="{{ $index }}"
                                                aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="producto-detalle-placeholder d-flex align-items-center justify-content-center">
                                <span>Sin imagen disponible</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card-body h-100 d-flex flex-column">
                        <h1 class="producto-detalle-titulo">{{ $producto->nombre_producto }}</h1>
                        <p class="producto-detalle-descripcion">{{ $producto->descripcion }}</p>

                        <dl class="producto-detalle-meta">
                            <div class="meta-item">
                                <dt>Precio</dt>
                                <dd>${{ number_format($producto->precio, 2) }}</dd>
                            </div>
                            <div class="meta-item">
                                <dt>Stock</dt>
                                <dd>{{ $producto->stock }}</dd>
                            </div>
                            <div class="meta-item">
                                <dt>Estado</dt>
                                <dd>
                                    <span
                                        class="badge {{ ($producto->estado_producto ?? '') === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($producto->estado_producto ?? 'desconocido') }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                        <div class="producto-detalle-actions mt-auto">
                            <a href="{{ route('dashboardecommerce.index') }}" class="btn btn-link">Volver al dashboard</a>
                            <button type="button" class="btn btn-primary">Anadir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .producto-detalle-wrapper {
            padding: 24px;
        }

        .producto-detalle-card {
            overflow: hidden;
        }

        .producto-detalle-media {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 320px;
            position: relative;
            overflow: hidden;
        }

        .producto-slider {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .producto-slider-track {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .producto-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.6s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .producto-slide.is-active {
            opacity: 1;
            position: relative;
        }

        .producto-detalle-imagen,
        .producto-detalle-video-slide {
            width: 100%;
            height: 100%;
            object-fit: cover;
            aspect-ratio: 4 / 3;
            border-radius: 8px;
        }

        .producto-slider-controls {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            pointer-events: none;
            padding: 0 12px;
        }

        .producto-slider-control {
            pointer-events: auto;
            background: rgba(0, 0, 0, 0.45);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            line-height: 1;
            transition: background 0.2s ease;
        }

        .producto-slider-control:hover {
            background: rgba(0, 0, 0, 0.65);
        }

        .producto-slider-indicators {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .producto-slider-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.5);
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .producto-slider-indicator.is-active {
            background: #fff;
            transform: scale(1.15);
        }

        .producto-slider:hover .producto-slider-control {
            opacity: 1;
        }

        .producto-detalle-placeholder {
            width: 100%;
            height: 100%;
            min-height: 320px;
            background: rgba(0, 0, 0, 0.05);
            color: var(--muted);
        }

        .producto-detalle-titulo {
            margin-bottom: 12px;
            font-size: 28px;
            font-weight: 600;
        }

        .producto-detalle-descripcion {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 24px;
        }

        .producto-detalle-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .producto-detalle-meta dt {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .producto-detalle-meta dd {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }

        .producto-detalle-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 768px) {
            .producto-detalle-wrapper {
                padding: 16px;
            }

            .producto-detalle-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.producto-slider').forEach(function (slider) {
                const slides = Array.from(slider.querySelectorAll('.producto-slide'));
                if (!slides.length) {
                    return;
                }

                const defaultInterval = Number(slider.dataset.interval) || 5000;
                const indicators = Array.from(slider.querySelectorAll('.producto-slider-indicator'));
                const prevButton = slider.querySelector('.producto-slider-control.prev');
                const nextButton = slider.querySelector('.producto-slider-control.next');

                let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));
                if (activeIndex === -1) {
                    activeIndex = 0;
                    slides[0].classList.add('is-active');
                }

                let timerId = null;

                const clearTimer = () => {
                    if (timerId) {
                        window.clearTimeout(timerId);
                        timerId = null;
                    }
                };

                const updateIndicators = (index) => {
                    indicators.forEach((indicator, i) => {
                        indicator.classList.toggle('is-active', i === index);
                    });
                };

                const stopVideoSlide = (slide) => {
                    if (!slide) {
                        return;
                    }
                    const video = slide.querySelector('video');
                    if (!video) {
                        return;
                    }

                    if (video._sliderMetaHandler) {
                        video.removeEventListener('loadedmetadata', video._sliderMetaHandler);
                        delete video._sliderMetaHandler;
                    }

                    if (video._sliderEndedHandler) {
                        video.removeEventListener('ended', video._sliderEndedHandler);
                        delete video._sliderEndedHandler;
                    }

                    if (video._sliderFallbackTimer) {
                        window.clearTimeout(video._sliderFallbackTimer);
                        delete video._sliderFallbackTimer;
                    }

                    video.pause();
                    try {
                        video.currentTime = 0;
                    } catch (error) {
                        /* ignore seek errors */
                    }
                };

                const playVideoSlide = (slide) => {
                    const video = slide.querySelector('video');
                    if (!video) {
                        return;
                    }
                    try {
                        video.currentTime = 0;
                    } catch (error) {
                        /* ignore seek errors */
                    }
                    const playPromise = video.play();
                    if (playPromise && typeof playPromise.catch === 'function') {
                        playPromise.catch(() => {});
                    }
                };

                const scheduleForVideo = (slide) => {
                    const video = slide.querySelector('video');
                    if (!video) {
                        return;
                    }

                    if (video._sliderMetaHandler) {
                        video.removeEventListener('loadedmetadata', video._sliderMetaHandler);
                        delete video._sliderMetaHandler;
                    }
                    if (video._sliderEndedHandler) {
                        video.removeEventListener('ended', video._sliderEndedHandler);
                        delete video._sliderEndedHandler;
                    }
                    if (video._sliderFallbackTimer) {
                        window.clearTimeout(video._sliderFallbackTimer);
                        delete video._sliderFallbackTimer;
                    }

                    const goForward = () => {
                        clearTimer();
                        goNext();
                    };

                    const setFallbackTimer = () => {
                        const durationMs = Math.max((video.duration || 0) * 1000, defaultInterval);
                        video._sliderFallbackTimer = window.setTimeout(goForward, durationMs);
                    };

                    const ensurePlayback = () => {
                        playVideoSlide(slide);
                        video._sliderEndedHandler = () => {
                            goForward();
                        };
                        video.addEventListener('ended', video._sliderEndedHandler, { once: true });
                        setFallbackTimer();
                    };

                    if (Number.isFinite(video.duration) && video.duration > 0) {
                        ensurePlayback();
                    } else {
                        video._sliderMetaHandler = () => {
                            video.removeEventListener('loadedmetadata', video._sliderMetaHandler);
                            delete video._sliderMetaHandler;
                            ensurePlayback();
                        };
                        video.addEventListener('loadedmetadata', video._sliderMetaHandler);
                    }
                };

                const scheduleNext = () => {
                    clearTimer();
                    const activeSlide = slides[activeIndex];
                    if (!activeSlide) {
                        return;
                    }
                    const type = activeSlide.dataset.slideType || 'imagen';
                    if (type === 'video') {
                        scheduleForVideo(activeSlide);
                    } else {
                        const durationAttr = parseInt(activeSlide.dataset.slideDuration, 10);
                        const durationMs = Number.isFinite(durationAttr) && durationAttr > 0 ? durationAttr : defaultInterval;
                        timerId = window.setTimeout(goNext, durationMs);
                    }
                };

                const goTo = (index) => {
                    if (index === activeIndex) {
                        return;
                    }

                    stopVideoSlide(slides[activeIndex]);
                    clearTimer();

                    slides[activeIndex].classList.remove('is-active');
                    slides[index].classList.add('is-active');

                    activeIndex = index;
                    updateIndicators(activeIndex);

                    const activeSlide = slides[activeIndex];
                    if ((activeSlide.dataset.slideType || 'imagen') === 'video') {
                        playVideoSlide(activeSlide);
                    }

                    scheduleNext();
                };

                const goNext = () => {
                    const nextIndex = (activeIndex + 1) % slides.length;
                    goTo(nextIndex);
                };

                const goPrev = () => {
                    const prevIndex = (activeIndex - 1 + slides.length) % slides.length;
                    goTo(prevIndex);
                };

                if (prevButton) {
                    prevButton.addEventListener('click', function () {
                        goPrev();
                    });
                }

                if (nextButton) {
                    nextButton.addEventListener('click', function () {
                        goNext();
                    });
                }

                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', function () {
                        goTo(index);
                    });
                });

                const pauseAuto = () => {
                    clearTimer();
                    const activeSlide = slides[activeIndex];
                    if (activeSlide && (activeSlide.dataset.slideType || 'imagen') === 'video') {
                        const video = activeSlide.querySelector('video');
                        if (video && video._sliderFallbackTimer) {
                            window.clearTimeout(video._sliderFallbackTimer);
                            delete video._sliderFallbackTimer;
                        }
                    }
                };

                const resumeAuto = () => {
                    scheduleNext();
                };

                slider.addEventListener('mouseenter', pauseAuto);
                slider.addEventListener('mouseleave', resumeAuto);
                slider.addEventListener('focusin', pauseAuto);
                slider.addEventListener('focusout', resumeAuto);

                updateIndicators(activeIndex);
                const initialSlide = slides[activeIndex];
                if ((initialSlide.dataset.slideType || 'imagen') === 'video') {
                    playVideoSlide(initialSlide);
                }
                scheduleNext();
            });
        });
    </script>
@endpush
