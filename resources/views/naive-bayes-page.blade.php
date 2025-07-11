{{-- File: resources/views/naive-bayes-page.blade.php --}}
@extends('layouts.naive-bayes')

@section('content')

    {{-- DATASET --}}
    <div x-show="activeTab === 'dataset'">
        @include('data-bayes.dataset')
    </div>

    {{-- INITIAL PROCESS --}}
    <div x-show="activeTab === 'initial_process'">
        @include('data-bayes.initial-process')
    </div>

    {{-- PERFORMANCE --}}
    <div x-show="activeTab === 'performance'">
        @include('data-bayes.performance')
    </div>

    {{-- PREDICTION --}}
    <div x-show="activeTab === 'prediction'">
        @include('data-bayes.prediction')
    </div>

@endsection
