<!-- resources/views/layouts/app.blade.php -->

{{--
    主版型 (Layout)，供所有子模板繼承。
    用法：子模板用 @extends('layouts.app') 套用本版型。
    @yield('title')：允許子模板自訂網頁標題。
    @section('sidebar')/@yield('sidebar')：側邊欄區塊，可被子模板覆寫，@parent 保留原內容。
    @yield('content')：主要內容區塊，必須由子模板覆寫。
--}}

<html>

<head>
    <title>App Name - @yield('title') {{-- 子模板可自訂標題 --}}</title>
</head>

<body>
    @section('sidebar') {{-- 預設 sidebar，可被子模板覆寫 --}}
        This is the master sidebar.
    @show

    <div class="container">
        @yield('content') {{-- 主要內容區塊，必須由子模板覆寫 --}}
    </div>
</body>

</html>
