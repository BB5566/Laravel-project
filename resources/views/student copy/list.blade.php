@extends('layouts.app')

@section('title', '學生列表') {{-- 這頁的標題 --}}

@section('sidebar') {{-- sidebar 可自訂或加內容 --}}
    @parent
    <p>這是學生專屬的側邊欄內容。</p>
@endsection

@section('content') {{-- 主要內容 --}}
    <h1>學生列表</h1>
    <ul>
        <li>王小明</li>
        <li>李小華</li>
        <li>陳大志</li>
    </ul>
@endsection
