@php
    $versionedAsset = static function (string $relativePath): ?string {
        $fullPath = public_path($relativePath);

        if (! file_exists($fullPath)) {
            return null;
        }

        return asset(str_replace('\\', '/', $relativePath)) . '?v=' . filemtime($fullPath);
    };

    $svgIcon = $versionedAsset('favicon.svg');
    $pngIcon = $versionedAsset('logosdreal.png');
    $icoIcon = $versionedAsset('favicon.ico');
    $dynamicFavicon = $versionedAsset('storage/school-profile/favicon-dynamic.png');

    $fallbackUrl = null;
    $fallbackType = 'image/png';

    // Prioritize the dynamic favicon from admin settings
    if ($dynamicFavicon) {
        $fallbackUrl = $dynamicFavicon;
        $fallbackType = 'image/png';
    } elseif ($pngIcon) {
        $fallbackUrl = $pngIcon;
        $fallbackType = 'image/png';
    }
@endphp

@if ($dynamicFavicon)
    <link rel="icon" type="image/png" href="{{ $dynamicFavicon }}">
    <link rel="apple-touch-icon" href="{{ $dynamicFavicon }}">
@elseif ($icoIcon)
    <link rel="icon" type="image/x-icon" href="{{ $icoIcon }}">
    <link rel="shortcut icon" href="{{ $icoIcon }}">
@endif

@if ($pngIcon)
    <link rel="icon" type="image/png" href="{{ $pngIcon }}">
    <link rel="apple-touch-icon" href="{{ $pngIcon }}">
@endif

@if (! $icoIcon && $fallbackUrl)
    <link rel="icon" type="{{ $fallbackType }}" href="{{ $fallbackUrl }}">
    <link rel="shortcut icon" href="{{ $fallbackUrl }}">
    <link rel="apple-touch-icon" href="{{ $fallbackUrl }}">
@endif
