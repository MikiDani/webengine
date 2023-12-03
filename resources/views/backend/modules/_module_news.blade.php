<form id="newmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'new' ]) }}" class="p-3 m-0 mt-3 bg-primary rounded" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="moduletype" value="news">
    <input type="hidden" name="last_sequence" value="@isset($moduledata['last_sequence']){{ $moduledata['last_sequence'] }} @else 0 @endisset">
    <div class="row p-0 m-0">
        <div class="content-left p-0 m-0 col-12 col-lg-6">
            <div class="row p-0 m-0 my-2">
                <p class="p-0 m-0">
                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                        <label>{{ __('messages.modules.textnewsdatetime') }}</label>
                    </div>
                    <div class="col">
                        <input type="date" name="new_date" class="form-control" autocomplete="off">
                    </div>
                </p>
            </div>
            <div class="row p-0 m-0 my-2">
                <p class="p-0 m-0">
                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                        <label>{{ __('messages.modules.textnewstitle') }}</label>
                    </div>
                    <div class="col">
                        <input type="text" name="new_title" class="form-control" autocomplete="off">
                    </div>
                </p>
            </div>
            <div class="row p-0 m-0 my-2">
                <p class="p-0 m-0">
                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                        <label>{{ __('messages.modules.textnewsimage') }}</label>
                    </div>
                    <div class="col">
                        <input type="file" name="new_image" class="form-control">
                    </div>
                </p>
            </div>
            <div class="row p-0 m-0 my-2">
                <p class="p-0 m-0">
                    <div class="p-0 m-0 col-auto label-min-width align-self-center">
                        <label>{{ __('messages.modules.textnewslink') }}</label>
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
                    <textarea name="new_message" class="form-control h-100">{{ __('messages.modules.textnewsmessage') }}</textarea>
                </div>
                <p class="p-0 m-0"></p>
            </div>
        </div>
        <button type="submit" class="btn btn-warning btn-sm mt-5">{{ __('messages.modules.textnewssubmit') }}</button>
    </div>

</form>
<form id="editmodule-form" method="post" action="{{ route("admin_module_save", ['menuid' => $menu['id'], 'moduleid' => $module['id'], 'type' => 'edit' ]) }}" class="p-3 m-0 mt-3 bg-light rounded" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="moduletype" value="news">
    @foreach($moduledata as $newsrow)
        <div class="row p-0 m-0">
            <div class="content-left p-0 m-0 col-12 col-lg-6">
                <div class="row p-0 m-0 my-2">
                    <p class="p-0 m-0">
                        <div class="p-0 m-0 col-auto label-min-width align-self-center">
                            <label>{{ __('messages.modules.textnewsdatetime') }}</label>
                        </div>
                        <div class="col">
                            <input type="date" name="edit_date[]" class="form-control" autocomplete="off">
                        </div>
                    </p>
                </div>
                <div class="row p-0 m-0 my-2">
                    <p class="p-0 m-0">
                        <div class="p-0 m-0 col-auto label-min-width align-self-center">
                            <label>{{ __('messages.modules.textnewstitle') }}</label>
                        </div>
                        <div class="col">
                            <input type="text" name="edit_title" class="form-control" autocomplete="off">
                        </div>
                    </p>
                </div>
                <div class="row p-0 m-0 my-2">
                    <p class="p-0 m-0">
                        <div class="p-0 m-0 col-auto label-min-width align-self-center">
                            <label>{{ __('messages.modules.textnewsimage') }}</label>
                        </div>
                        <div class="col">
                            <input type="file" name="edit_image" class="form-control">
                        </div>
                    </p>
                </div>
                <div class="row p-0 m-0 my-2">
                    <p class="p-0 m-0">
                        <div class="p-0 m-0 col-auto label-min-width align-self-center">
                            <label>{{ __('messages.modules.textnewslink') }}</label>
                        </div>
                        <div class="col">
                            <input type="text" name="edit_link" class="form-control" autocomplete="off">
                        </div>
                    </p>
                </div>
            </div>
            <div class="content-right p-0 m-0 col-12 col-lg-6 col">
                <div class="row p-0 m-0 my-2 h-100">
                    <div class="col p-0 m-0 h-100">
                        <textarea name="edit_message" class="form-control h-100">{{ __('messages.modules.textnewsmessage') }}</textarea>
                    </div>
                    <p class="p-0 m-0"></p>
                </div>
            </div>
            <button type="submit" class="btn btn-warning btn-sm mt-5">{{ __('messages.modules.textnewssubmit') }}</button>
        </div>
    @endforeach
    <button type="submit" class="btn btn-warning btn-sm mt-5">{{ __('messages.modules.texteditsubmit') }}</button>
</form>

@php

    print "MODULE:";
    dump($module);
    print "MODULEDATA:";
    dump($moduledata);

@endphp