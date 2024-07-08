<tr>
    <td class="text-muted text-center bg-transparent" colspan="100%">
        <div class="p-3 d-flex flex-wrap align-items-center flex-column justify-content-center empty-message">
            <img src="{{getImage('assets/images/empty_box.png')}}">
            <span>{{ __($emptyMessage) }}</span>
        </div>
    </td>
</tr>

@push('style')
    <style>
     
        .empty-message img{
            max-width: 80px;
        }
        .empty-message span{
            font-size: 0.875rem;
        }
    </style>
@endpush
