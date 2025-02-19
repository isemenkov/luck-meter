@extends('template')

@section('title', 'Luck Meter')

@section('content')
<x-link-manager :pageUrl="$pageUrl" />
<x-lucky-score :score="$score" />
<x-score-history :historyResults="$historyResults" />
@endsection
