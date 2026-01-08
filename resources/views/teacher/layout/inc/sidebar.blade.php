@php
use Illuminate\Support\Str;
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ '' }}" class="logo" target="_blank">
                <img src="{{ asset('mix/image/logo.png') }}" alt="navbar"
                    class="navbar-brand" height="20">
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="{{ route('teacher.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Str::is('admin.avaliability.*', request()->route()->getName()) ? 'active' : '' }}">
                    <a href="{{ route('teacher.availability.index') }}">
                        <i class="fa-solid fa-calendar-check"></i>
                        <p>Availability</p>
                    </a>
                </li>
                <li class="nav-item {{ Str::is('admin.avaliability.*', request()->route()->getName()) ? 'active' : '' }}">
                    <a href="{{ route('teacher.availability.index') }}">
                        <i class="fa-solid fa-calendar-check"></i>
                        <p>Availability</p>
                    </a>
                </li>
                {{-- <li class="nav-item {{ (request()?->route()?->getName() ?? '') == 'admin.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
