@extends('Layouts.app-layout')
@section('content')
    @livewire('album.album-view',['albumId'=>$id])
@endsection
