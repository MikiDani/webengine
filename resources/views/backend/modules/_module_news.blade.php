@section('controller-box')
    <div class="controller-box row p-0 m-0">
        <div class="col-12 col-lg-6 p-0 m-0 mb-2 mb-lg-0 pe-0 pe-lg-2">
            <button type="submit" class="btn btn-warning btn-sm w-100">{{ __('messages.modules.news.texteditsubmit') }}</button>
        </div>
        <div class="row col-12 col-lg-6 p-0 m-0">
            <div class="allopen p-0 m-0 pe-2 col-6"><button type="button" class="btn btn-secondary btn-sm w-100">{{ __('messages.modules.news.textallopen') }}</button></div>
            <div class="allclose p-0 m-0 col-6"><button type="button" class="btn btn-secondary btn-sm w-100">{{ __('messages.modules.news.textallclose') }}</button></div>
        </div>
    </div>
@endsection

<div id="news-box" class="row p-0 m-0">
    <button class="bg-info mt-3 rounded-top border-0 p-1 border border-bottom border-5 border-dark" id="collapseButton" data-bs-toggle="collapse" data-bs-target="#new-news-collapse">
        {{ __('messages.modules.news.textaddnewnews') }}
        <span class="collapse-icon">
            <i class="bi bi-chevron-bar-down"></i>
        </span>
    </button>
    <div id="new-news-collapse" class="collapse p-0 m-0">
        {{-- NEW --}}
        <form id="newmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'new' ]) }}" class="p-3 m-0 bg-primary rounded-bottom" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="moduletype" value="news">
            <input type="hidden" name="last_sequence" value="@isset($last_sequence){{ $last_sequence }} @else 0 @endisset">
            <div class="row p-0 m-0">
                <div class="content-left p-0 m-0 col-12 col-lg-6">
                    <div class="row p-0 m-0 my-2">
                        <p class="p-0 m-0">
                            <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                <label>{{ __('messages.modules.news.textnewstitle') }}</label>
                            </div>
                            <div class="col">
                                <input type="text" name="new_title" class="form-control" autocomplete="off">
                            </div>
                        </p>
                    </div>
                    <div class="row p-0 m-0 my-2">
                        <p class="p-0 m-0">
                            <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                <label>{{ __('messages.modules.news.textnewsdatetime') }}</label>
                            </div>
                            <div class="col">
                                <input type="date" name="new_date" class="form-control" autocomplete="off">
                            </div>
                        </p>
                    </div>
                    <div class="row p-0 m-0 my-2">
                        <p class="p-0 m-0">
                            <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                <label>{{ __('messages.modules.news.textnewsimage') }}</label>
                            </div>
                            <div class="col">
                                <input type="file" name="new_image" class="form-control">
                            </div>
                        </p>
                    </div>
                    <div class="row p-0 m-0 my-2">
                        <p class="p-0 m-0">
                            <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                <label>{{ __('messages.modules.news.textnewslink') }}</label>
                            </div>
                            <div class="col">
                                <input type="text" name="new_link" class="form-control" autocomplete="off">
                            </div>
                        </p>
                    </div>
                </div>
                <div class="content-right p-0 m-0 col-12 col-lg-6 col">
                    <div class="row p-0 m-0 my-2 h-100">
                        <div class="col p-0 m-0 h-100">
                            <textarea name="new_message" class="form-control h-100">{{ __('messages.modules.news.textnewsmessage') }}</textarea>
                        </div>
                        <p class="p-0 m-0"></p>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning btn-sm mt-5">{{ __('messages.modules.news.textnewssubmit') }}</button>
            </div>
        </form>
    </div>
    {{-- EDIT --}}
    <form id="editmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'edit' ]) }}" class="p-0 m-0 mt-2 bg-light rounded" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="moduletype" value="news">

        @yield('controller-box')

        <div id="news-all" class="p-0 m-0 mb-2">
            @foreach($moduledata as $row)
                <div class="editNewsSortable editNewsSortable_{{ $row['id'] }} p-0 m-0">
                    {{-- head --}}
                    <div id="newsrow-head_{{ $row['id'] }}" data-id="{{ $row['id'] }}" class="news-label-pos d-flex justify-content-between align-items-center mt-2 m-0 p-2 bg-success text-white fw-bold rounded-top">
                        <div class="move-arrows-pos">
                            <i class="bi bi-arrows-move d-inline-block align-middle"></i>
                        </div>
                        <div class="openclose-arrows-pos" data-id="{{ $row['id'] }}">
                            <i class="bi bi-caret-down-fill align-middle"></i>
                        </div>
                        <div class="delete-arrows-pos" data-id="{{ $row['id'] }}">
                            <i class="minus-button-menulist d-inline-block align-middle"></i>
                        </div>
                        <div class="newsrow-title d-inline">{{ $row['news_title'] }}</div> <div class="newsrow-datetime d-inline">{{ \Carbon\Carbon::parse($row['news_datetime'])->format('Y-m-d') }}</div>
                    </div>
                    {{-- content --}}
                    <div id="newsrow-content_{{ $row['id'] }}" class="newsrow-content row m-0 p-3 mb-2 bg-light border border-2 border-top-0 rounded-bottom" style="display:none;">
                        <div class="content-left p-0 m-0 col-12 col-lg-6">
                            <div class="row p-0 m-0 my-2">
                                <p class="p-0 m-0">
                                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                        <label>{{ __('messages.modules.news.textnewsdatetime') }}</label>
                                    </div>
                                    <div class="col">
                                        <input type="date" name="edit[{{ $row['id'] }}][date]" data-id="{{ $row['id'] }}" @isset($row['news_datetime']) value="{{ \Carbon\Carbon::parse($row['news_datetime'])->format('Y-m-d') }}" @endisset class="form-control" autocomplete="off">
                                    </div>
                                </p>
                            </div>
                            <div class="row p-0 m-0 my-2">
                                <p class="p-0 m-0">
                                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                        <label>{{ __('messages.modules.news.textnewstitle') }}</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="edit[{{ $row['id'] }}][title]" data-id="{{ $row['id'] }}" @isset($row['news_title']) value="{{$row['news_title']}}" @endisset class="form-control" autocomplete="off">
                                    </div>
                                </p>
                            </div>
                            <div class="row p-0 m-0 my-2">
                                <p class="p-0 m-0">
                                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                        <label>{{ __('messages.modules.news.textnewslink') }}</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="edit[{{ $row['id'] }}][link]" @isset($row['news_link']) value="{{ $row['news_link'] }}" @endisset class="form-control" autocomplete="off">
                                    </div>
                                </p>
                            </div>
                            <div class="row p-0 m-0 my-2">
                                @if($row['news_image'])
                                    <img src="{{ Storage::url('public/storage_news/' . $row['news_image']) }}" alt="{{ $row['news_title'] }}">
                                @else
                                    <p class="p-0 m-0">
                                        <div class="p-0 m-0 col-auto label-min-width align-self-center">
                                            <label>{{ __('messages.modules.news.textnewsimage') }}</label>
                                        </div>
                                        @if(true)
                                            <div class="col">
                                                <input type="file" name="edit[{{ $row['id'] }}][image]" class="form-control">
                                            </div>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="content-right p-0 m-0 col-12 col-lg-6 col">
                            <div class="row p-0 m-0 my-2 h-100">
                                <div class="col p-0 m-0 h-100">
                                    <textarea name="edit[{{ $row['id'] }}][message]" class="form-control h-100">{{ $row['news_message'] }}</textarea>
                                </div>
                                <p class="p-0 m-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if(count($moduledata)>4)
            @yield('controller-box')
        @endif
    </form>
</div>
<script>
    var texteditnewsdeletemessage = "{{ __('messages.modules.news.texteditnewsdeletemessage') }}"
    var textemptymessage = "{{ __('messages.modules.news.textemptymessage') }}"
</script>