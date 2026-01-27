@extends('errors.minimal')

@section('title', 'Terjadi Kesalahan Server')
@section('code', '500')
@section('message', 'Terjadi Kesalahan Internal')
@section('description', 'Maaf, server kami sedang mengalami gangguan. Kami sedang berusaha memperbaikinya segera.')

@section('icon')
<path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
@endsection
