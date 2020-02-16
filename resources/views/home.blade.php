@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <table class="table-fixed">
            <tr>
                <th style="width: 20%"></th>
                <th style="width: 3%"></th>
                <th style="width: 45%"></th>
                <th style="width: 15%"></th>
                <th style="width: 15%"></th>
            </tr>
            @foreach ($channels as $channel)
                <tr class="border-top">
                    <td class="pt-4 pb-4" rowspan="4">
                        <a href="{{  route('channel', $channel->uid)  }}">
                            <img class="rounded-circle img-md" src="{{  $channel->thumbnail  }}" alt="thumbnail">
                        </a>
                    </td>
                    <td class="pt-4" colspan="3">
                        <h2 class="text-truncate">{{  $channel->name  }}</h2>
                    </td>
                    <td class="text-right">{{  number_format_short($channel->subscribers)  }} 位訂閱者</td>
                </tr>
                @foreach ($channel->videos as $ind => $video)
                    @if (count($channel->videos) === $ind + 1)
                        <tr class="pb-4">
                    @else
                        <tr>
                    @endif
                        <td>#{{  $ind + 1  }}</td>
                        <td class="text-truncate pr-4" title="{{  $video->name  }}">{{  $video->name  }}</td>
                        <td>觀看次數：{{ number_format_short($video->views)  }} </td>
                        <td>{{  $video->published_at  }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>
@endsection