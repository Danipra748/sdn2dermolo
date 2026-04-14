@php
    $versionedAsset = static function (string $relativePath): ?string {
        $fullPath = public_path($relativePath);

        if (! file_exists($fullPath)) {
            return null;
        }

        return asset(str_replace('\\', '/', $relativePath)) . '?v=' . filemtime($fullPath);
    };

    $svgIcon = $versionedAsset('favicon.svg');
    $jpegIcon = $versionedAsset('logo.jpeg');
    $pngIcon = $versionedAsset('storage/school-profile/logo.jpeg');
    $icoIcon = $versionedAsset('favicon.ico');

    $fallbackUrl = null;
    $fallbackType = 'image/x-icon';

    if (! $svgIcon && ! $pngIcon && ! $icoIcon) {
        $faviconProfile = $schoolProfile ?? \App\Models\SchoolProfile::getOrCreate();
        $mimeTypes = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
        ];

        $fallbackCandidates = [];

        if (! empty($faviconProfile->logo)) {
            $logoFile = ltrim($faviconProfile->logo, '/');
            $logoExtension = strtolower(pathinfo($logoFile, PATHINFO_EXTENSION));

            $fallbackCandidates[] = [
                'path' => public_path('storage/' . $logoFile),
                'url' => asset('storage/' . $logoFile),
                'type' => $mimeTypes[$logoExtension] ?? 'image/png',
            ];
        }

        $defaultLogoMatches = glob(storage_path('app/public/logos/sd-negeri-2-dermolo.*')) ?: [];

        if (! empty($defaultLogoMatches)) {
            $defaultLogoName = basename($defaultLogoMatches[0]);
            $defaultLogoExtension = strtolower(pathinfo($defaultLogoName, PATHINFO_EXTENSION));

            $fallbackCandidates[] = [
                'path' => public_path('storage/logos/' . $defaultLogoName),
                'url' => asset('storage/logos/' . $defaultLogoName),
                'type' => $mimeTypes[$defaultLogoExtension] ?? 'image/png',
            ];
        }

        foreach ($fallbackCandidates as $candidate) {
            if (file_exists($candidate['path'])) {
                $fallbackUrl = $candidate['url'] . '?v=' . filemtime($candidate['path']);
                $fallbackType = $candidate['type'];
                break;
            }
        }
    }
@endphp

@if ($svgIcon)
    <link rel="icon" type="image/svg+xml" href="{{ $svgIcon }}">
@endif

@if ($jpegIcon)
    <link rel="icon" type="image/jpeg" href="{{ $jpegIcon }}">
@endif

@if ($icoIcon)
    <link rel="icon" type="image/x-icon" href="{{ $icoIcon }}">
    <link rel="shortcut icon" href="{{ $icoIcon }}">
@endif

@if ($pngIcon)
    <link rel="apple-touch-icon" href="{{ $pngIcon }}">
@endif

@if (! $svgIcon && ! $jpegIcon && ! $icoIcon && $fallbackUrl)
    <link rel="icon" type="{{ $fallbackType }}" href="{{ $fallbackUrl }}">
    <link rel="shortcut icon" href="{{ $fallbackUrl }}">
    <link rel="apple-touch-icon" href="{{ $fallbackUrl }}">
@endif
