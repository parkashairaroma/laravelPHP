 @extends('admin.layouts.control')

@section('content')

<section class="websites page">
    <div class="actionbar">
        <div class="header"><h3>Website Management</h3></div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th width="200px">Domain</th>
                <th width="200px">Country</th>
                <th width="100px">Language</th>
                <th width="5px">Status</th>
                <th width="90px" class="actioncol">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($websites as $website)
                <tr data-id="{{ $website->web_id }}">
                    <td><a href="/admin/websites/edit/{{ $website->web_id }}" class="tip edit" title="Edit">{{ $website->web_title }}</a></td>
                    <td>{{ $website->web_main_domain }}</td>
                    <td>{{ $website->cou_name }}</td>
                    <td>{{ $website->web_htmllang }}</td>
                    <td class="web_status"><span class="label label-{{ $websiteStatusColours[$website->web_status] }}">{!! $websiteStatusNames[$website->web_status] !!}</span></td>
                    <td colspan="2" class="actioncol">  
                        <a href="http://{{ $website->web_main_domain }}" target="_blank" class="btn btn-default btn-sm view"><i class="fa fa-eye tip" title="View"></i></a>
                        <a href="/admin/websites/edit/{{ $website->web_id }}" class="btn btn-success btn-sm edit"><i class="fa fa-pencil tip" title="Edit"></i></a>                  
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script>
$(function() {});
</script>

@stop