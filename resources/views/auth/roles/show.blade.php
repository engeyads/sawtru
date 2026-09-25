@extends('home')


@section('articles')
    @can('list-role')

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    @php
        $groups = [
            'Users' => [], 'Settings' => [], 'Projects' => [],
            'Purchases' => [], 'Roles' => [], 'Other' => [],
        ];
        foreach ($rolePermissions as $p) {
            $n = $p->name;
            if (str_contains($n, 'user'))              $groups['Users'][] = $p;
            elseif (str_contains($n, 'setting'))       $groups['Settings'][] = $p;
            elseif (str_contains($n, 'role'))          $groups['Roles'][] = $p;
            elseif (str_contains($n, 'purchase'))      $groups['Purchases'][] = $p;
            elseif (str_contains($n, 'project')
                 || str_contains($n, 'assembling')
                 || str_contains($n, 'pdf'))           $groups['Projects'][] = $p;
            else                                       $groups['Other'][] = $p;
        }
        $groups = array_filter($groups);
    @endphp

    <div class="role-view">
        <div class="role-view-head">
            <h2>Show Role</h2>
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
        </div>

        <div class="role-name">
            <span class="field-label">Name</span>
            {{ $role->name }}
        </div>

        <span class="field-label">Permissions</span>
        @if (count($groups))
            @foreach ($groups as $groupName => $items)
                <div class="perm-section">
                    <h3>{{ $groupName }}</h3>
                    <div class="perm-chips">
                        @foreach ($items as $value)
                            <span class="perm-chip">{{ ucfirst(str_replace('-', ' ', $value->name)) }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <p class="no-perms">This role has no permissions.</p>
        @endif
    </div>

    @else
        <div><h2>You are not allowed to enter this page...</h2></div>
    @endcan
@endsection
