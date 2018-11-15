 @extends('admin.layouts.control')

@section('content')

<section class="pages page">
    <div class="actionbar">
        <div class="header"><h3>Page Management</h3></div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th width="50%">URL</th>
                <th width="200px">Status</th>
                <th width="110px" class="actioncol">Actions</th>
            </tr>
            <tr>
                <th colspan="4">Shared</th>
            </tr>
        </thead>
        <tbody>
            @include('admin.pages.list-partial', ['viewable' => false, 'subsite' => 2])
        </tbody>
        <thead>
            <tr>
                <th colspan="4">Individual</th>
            </tr>
        </thead>
        <tbody>
            @include('admin.pages.list-partial', ['viewable' => true, 'subsite' => 0])
        </tbody>
    </table>
</section>

<script>
$(function() {});
</script>

@stop