@props([
    'id'    => 'phone',
    'name'  => 'phone',
    'value' => '',
])

@php
$countries = [
    ['+961','🇱🇧','Lebanon'],
    ['+1',  '🇺🇸','USA / Canada'],
    ['+44', '🇬🇧','UK'],
    ['+971','🇦🇪','UAE'],
    ['+966','🇸🇦','Saudi Arabia'],
    ['+974','🇶🇦','Qatar'],
    ['+965','🇰🇼','Kuwait'],
    ['+973','🇧🇭','Bahrain'],
    ['+968','🇴🇲','Oman'],
    ['+962','🇯🇴','Jordan'],
    ['+963','🇸🇾','Syria'],
    ['+964','🇮🇶','Iraq'],
    ['+20', '🇪🇬','Egypt'],
    ['+212','🇲🇦','Morocco'],
    ['+216','🇹🇳','Tunisia'],
    ['+213','🇩🇿','Algeria'],
    ['+90', '🇹🇷','Turkey'],
    ['+357','🇨🇾','Cyprus'],
    ['+30', '🇬🇷','Greece'],
    ['+33', '🇫🇷','France'],
    ['+49', '🇩🇪','Germany'],
    ['+39', '🇮🇹','Italy'],
    ['+34', '🇪🇸','Spain'],
    ['+31', '🇳🇱','Netherlands'],
    ['+32', '🇧🇪','Belgium'],
    ['+41', '🇨🇭','Switzerland'],
    ['+43', '🇦🇹','Austria'],
    ['+46', '🇸🇪','Sweden'],
    ['+47', '🇳🇴','Norway'],
    ['+45', '🇩🇰','Denmark'],
    ['+61', '🇦🇺','Australia'],
    ['+55', '🇧🇷','Brazil'],
    ['+52', '🇲🇽','Mexico'],
    ['+91', '🇮🇳','India'],
    ['+86', '🇨🇳','China'],
    ['+81', '🇯🇵','Japan'],
    ['+82', '🇰🇷','South Korea'],
];
@endphp

<div class="flex overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 transition focus-within:border-giftos focus-within:ring-2 focus-within:ring-giftos/30 sm:rounded-xl">

    <select id="{{ $id }}-country"
            name="{{ $name }}_code"
            class="shrink-0 border-r border-zinc-200 bg-transparent py-2 pl-2 pr-1 text-xs font-medium text-zinc-700 outline-none cursor-pointer sm:py-3 sm:pl-3 sm:pr-2 sm:text-sm">
        @foreach ($countries as [$code, $flag, $cname])
            <option value="{{ $code }}">{{ $flag }} {{ $cname }} ({{ $code }})</option>
        @endforeach
    </select>

    <input type="tel"
           id="{{ $id }}-local"
           name="{{ $name }}"
           class="flex-1 min-w-0 bg-transparent px-3 py-2 text-sm text-zinc-900 outline-none placeholder-zinc-400 sm:px-4 sm:py-3"
           placeholder="81 000 000"
           autocomplete="tel-national" />

</div>
