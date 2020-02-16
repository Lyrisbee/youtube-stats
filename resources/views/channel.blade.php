@extends('layouts.app')

@section('content')
    <main class="container mt-3">
        <div class="row">
            @component('layouts.sidebar')

                @slot('sidebarInfo')
                    <p>
                        <img class="rounded-circle img-md" src="{{  $channel->thumbnail  }}" alt="thumbnail">
                    </p>
                    <p class="channel-name"><h3>{{  $channel->name  }}</h3></p>
                    <p>{{  number_format_short($channel->subscribers)  }} 位訂閱者</p>
                    <p>{{  number_format_short($channel->videos)  }} 部影片</p>
                @endslot

                @slot('sidebarNavLink')
                    <a href="/channel/{{$channel->uid}}/statistics" class="nav-link pl-5 {{  isset($channel->statisics) ? 'active' : '' }}">統計數據</a>
                    <a href="/channel/{{$channel->uid}}/playlists" class="nav-link pl-5  {{  isset($channel->playlists) ? 'active' : '' }}">影片清單</a>
                @endslot
            @endcomponent
            <div class="centerbar bg-blanchedalmond">
                <div class="mt-4">
                    <table class="table-fixed mt-4">
                        <div class="paginate text-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item {{  ($channel->playlists->currentPage() <= 1) ? 'disabled' : ''  }}">
                                        <a class="page-link" href="{{  route('playlists', $channel->uid) . '?page=1'}}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    @if ($channel->playlists->currentPage() > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{  route('playlists', $channel->uid) . '?page=' . ($channel->playlists->currentPage() - 1)}}">
                                            {{  $channel->playlists->currentPage() - 1  }}
                                        </a>
                                    </li>
                                    @endif
                                    <li class="page-item active"><a class="page-link" href="#">{{  $channel->playlists->currentPage()  }}</a></li>
                                    @if ($channel->playlists->currentPage() < $channel->playlists->lastPage())
                                        <li class="page-item">
                                            <a class="page-link" href="{{  route('playlists', $channel->uid) . '?page=' . ($channel->playlists->currentPage() + 1)}}">
                                                {{  $channel->playlists->currentPage() + 1  }}
                                            </a>
                                        </li>
                                    @endif
                                    <li class="page-item {{  ($channel->playlists->currentPage() >= $channel->playlists->lastPage()) ? 'disabled' : ''  }}">
                                         <a class="page-link" href="{{  route('playlists', $channel->uid) . '?page=' . ($channel->playlists->lastPage())}}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        @foreach ($channel->playlists as $ind => $video)
                            @if ($ind%3 === 0)
                                <tr>
                            @endif
                                <td class="pr-4 pl-4">
                                    <a href="#">
                                        <p><img class="yt-img" src="https://i.ytimg.com/vi/{{$video->uid}}/hqdefault.jpg" alt="thumbnail"></p>
                                        <p class="text-truncate-height" title="{{$video->name}}">{{$video->name}}</p>
                                        <p>觀看次數：{{  number_format_short($video->views)  }} 次，{{  $video->create_at  }}</p>
                                    </a>
                                </td>
                            @if ($ind%3 === 2)
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection