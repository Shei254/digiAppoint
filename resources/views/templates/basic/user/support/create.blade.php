@extends('Template::layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="text-white">{{ __($pageTitle) }}</h5>
            </div>
            <div class="card-body">
                <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">@lang('Subject')</label>
                            <input type="text" name="subject" value="{{old('subject')}}" class="form-control form--control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">@lang('Priority')</label>
                            <select name="priority" class="form-control form--control" required>
                                <option value="3">@lang('High')</option>
                                <option value="2">@lang('Medium')</option>
                                <option value="1">@lang('Low')</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label class="form-label">@lang('Message')</label>
                            <textarea name="message" id="inputMessage" rows="6" class="form-control form--control" required>{{old('message')}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="text-end">
                            <button type="button" class="btn btn--base btn--sm addFile">
                                <i class="las la-plus"></i> @lang('Add New')
                            </button>
                        </div>
                        <div class="file-upload">
                            <label class="form-label">@lang('Attachments')</label> <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                            <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control mb-2"/>
                            <div id="fileUploadsContainer"></div>
                            <p class="ticket-attachments-message text-muted">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn--base w-100" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-outline--base btn--sm" href="{{ route('ticket.index') }}">
        <i class="las la-list"></i>@lang('Ticket List')
    </a>
@endpush

@push('style')
    <style>
        .input-group-text:focus{
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click',function(){
                if (fileAdded >= 4) {
                    notify('error','You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button type="button" class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
