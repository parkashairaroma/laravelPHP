@extends('admin.layouts.control')

@section('content') 

<section class="blogs page">
    <div class="actionbar">
        <div class="header">
            <h3>Members List</h3>
        </div>
    </div>
    <table class="table" id="membersTable">
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Country</th>
                <th>Phone</th>
                <th>Activated</th>
                <th>Newsletter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
            <tr data-id="{{ $member->acc_id }}">
                <td>{{ $member->acc_id }}</td>
                <td>{{ $member->acc_firstname }}</td>
                <td>{{ $member->acc_lastname }}</td>
                <td>{{ $member->acc_email }}</td>
                <td>{{ $member->acc_city }}</td>
                <td>{{ $member->cou_name }}</td>
                <td>{{ $member->acc_phone }}</td>
                <td><?=($member->acc_activated == '1')? 'Yes':'No'?></td>
                <td><?=($member->acc_newsletter == '1')? 'Yes':'No'?></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script>
    $(document).ready(function () {
        $('#membersTable').dataTable({
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [[ 0, "desc" ]],
            iDisplayLength: 10
        });
});
</script>

@stop
