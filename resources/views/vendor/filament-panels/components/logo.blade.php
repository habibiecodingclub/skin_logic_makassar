{{-- @php
    $brandName = "Skin Logic";
    $brandLogo = asset('images/logo.png');
    /* code sebelum saya ganti "filament()->getBrandLogo();" */
    $brandLogoHeight = '5rem';
    //saya mengganti code "filament()->getBrandLogoHeight() ?? '1.5rem';" menjadi ukuran logo yang saya ingin kan
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoClasses = fn (bool $isDarkMode): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo',
        'flex' => ! $hasDarkModeBrandLogo,
        'flex dark:hidden' => $hasDarkModeBrandLogo && (! $isDarkMode),
        'hidden dark:flex' => $hasDarkModeBrandLogo && $isDarkMode,
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

@capture($content, $logo, $isDarkMode = false)
    @if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
        <div
            {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }}
        >
            {{ $logo }}
        </div>
    @elseif (filled($logo))
        <img
            alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
            src="{{ $logo }}"
            {{
                $attributes
                    ->class([$getLogoClasses($isDarkMode)])
                    ->style([$logoStyles])
            }}
        />
    @else
        <div
            {{
                $attributes->class([
                    $getLogoClasses($isDarkMode),
                    'text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
                ])
            }}
        >
            {{ $brandName }}
        </div>
    @endif
@endcapture

{{ $content($brandLogo) }}

@if ($hasDarkModeBrandLogo)
    {{ $content($darkModeBrandLogo, isDarkMode: true) }}
@endif --}}

@php
    $brandName = "Skin Logic";
    $brandLogo = asset('images/logo.png');
    $brandLogoHeight = '4.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoClasses = fn (bool $isDarkMode): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo',
        'flex items-center', // Menjadikan flex agar sejajar dengan teks
        'flex dark:hidden' => $hasDarkModeBrandLogo && (! $isDarkMode),
        'hidden dark:flex' => $hasDarkModeBrandLogo && $isDarkMode,
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

@capture($content, $logo, $isDarkMode = false)
    <div class="flex items-center space-x-3">
        @if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
            <div
                {{
                    $attributes
                        ->class([$getLogoClasses($isDarkMode)])
                        ->style([$logoStyles])
                }}
            >
                {{ $logo }}
            </div>
        @elseif (filled($logo))
            <img
                alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
                src="{{ $logo }}"
                {{
                    $attributes
                        ->class([$getLogoClasses($isDarkMode)])
                        ->style([$logoStyles])
                }}
            />
        @else
            <div
                {{
                    $attributes->class([
                        $getLogoClasses($isDarkMode),
                        'text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
                    ])
                }}
            >
                {{ $brandName }}
            </div>
        @endif

        <!-- Tambahan teks di samping logo -->
        <span class="text-base font-semibold !important" style="color: #D7CC8A">
            Skinlogic Makassar
        </span>
    </div>
@endcapture

{{ $content($brandLogo) }}

@if ($hasDarkModeBrandLogo)
    {{ $content($darkModeBrandLogo, isDarkMode: true) }}
@endif
