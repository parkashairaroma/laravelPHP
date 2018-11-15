@foreach ($pages as $page)
    @if ($page->pag_subsite == $subsite)            
    <tr data-id="{{ $page->pag_id }}" data-url="{{ $siteTranslations['links'][$page->pag_url]['url'] }}">
        <td>
            <a href="/admin/pages/edit/{{ $page->pag_id }}" class="tip edit" title="Edit">{{ $page->pag_name }}</a>
        </td>
        <td>{{ $siteTranslations['links'][$page->pag_url]['url'] }}</td>
        <td>
        <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" style="width:100%">
                <span>{{ $page->siteTokens->count() }} / {{ $page->baseTokens->count() }}</span>
            </div>
        </div>
        </td>
        <td class="actioncol">
            @if ($viewable) 
                <a href="{{ $siteTranslations['links'][$page->pag_url]['url'] }}" target="_blank" class="btn btn-default btn-sm view" data><i class="fa fa-eye tip-left" title="View {{ $page->pag_name }}" ></i></a>
            @endif
            <a href="/admin/pages/edit/{{ $page->pag_id }}" class="btn btn-success btn-sm edit"><i class="fa fa-pencil tip" title="Edit"></i></a>
        </td>
    </tr>
    @endif
@endforeach