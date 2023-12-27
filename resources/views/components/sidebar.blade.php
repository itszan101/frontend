@php

    $links = [
        [
            'href' => 'dashboard',
            'text' => 'Dashboard',
            'is_multi' => false,
            'section_icon' => 'fas fa-fire',
        ],
        // [
        //     'href' => 'client',
        //     'text' => 'List seluruh domain',
        //     'is_multi' => false,
        //     'section_icon' => 'fas fa-layer-group',
        // ],
        // [
        //     'href' => [
        //         [
        //             'section_text' => 'Domain AWH',
        //             'section_list' => [['href' => 'client', 'text' => 'List Client'], ['href' => 'AddClient', 'text' => 'Tambah Client']],
        //             'section_icon' => 'fas fa-user',
        //         ],
        //     ],
        //     'text' => 'Domain',
        //     'is_multi' => true,
        // ],
        [
            'href' => [
                [
                    'section_text' => 'Post',
                    'section_list' => [['href' => 'post', 'text' => 'List Post'], ['href' => 'createPost', 'text' => 'Create Post']],
                    'section_icon' => 'fas fa-user',
                ],
            ],
            'text' => 'Post',
            'is_multi' => true,
        ],
    ];

    $navigation_links = array_to_object($links);
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img class="d-inline-block" width="32px" height="30.61px" src="{{ asset('assets/auth/img/logo_awh.png') }}"
                alt="">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">

            </a>
        </div>
        @foreach ($navigation_links as $link)
            <ul class="sidebar-menu">
                <li class="menu-header">{{ $link->text }}</li>
                @if (!$link->is_multi)
                    <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route($link->href) }}"><i
                                class="{{ $link->section_icon }}"></i><span>{{ $link->text }}</span></a>
                    </li>
                @else
                    @foreach ($link->href as $section)
                        @php
                            $routes = collect($section->section_list)
                                ->map(function ($child) {
                                    return Request::routeIs($child->href);
                                })
                                ->toArray();

                            $is_active = in_array(true, $routes);
                        @endphp

                        <li class="dropdown {{ $is_active ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                    class="{{ $section->section_icon }}"></i>
                                <span>{{ $section->section_text }}</span></a>
                            <ul class="dropdown-menu">
                                @foreach ($section->section_list as $child)
                                    <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a
                                            class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul>
        @endforeach
    </aside>
</div>
