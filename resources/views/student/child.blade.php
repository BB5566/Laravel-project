<!-- resources/views/child.blade.php -->

{{--
    這是子模板，繼承 resources/views/layouts/app.blade.php 主版型。
    @extends('layouts.app') 代表套用主版型。
    @section('title', 'Child Title') 用來設定主版型 <title> 的內容，對應 @yield('title')。
    @section('sidebar') 可覆寫主版型 sidebar 區塊，@parent 會保留主版型內容。
    @section('content') 則覆寫主版型 content 區塊。
--}}

@extends('layouts.app')

@section('title', 'Child Title') {{-- 設定主版型 <title> 內容 --}}

@section('sidebar') {{-- 覆寫主版型 sidebar，@parent 保留原內容 --}}
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content') {{-- 覆寫主版型 content 區塊 --}}
    <p>This is my body content.</p>
    <p>This is my body content.</p>
    <p>This is my body content.</p>
    <p>This is my body content.</p>
    <p>This is my body content.</p>
    <p>This is my body content.</p>
    <p>This is my body content.</p>
    <p>This is my body content.</p>
@endsection
