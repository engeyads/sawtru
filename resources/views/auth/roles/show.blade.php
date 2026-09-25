@extends('home')


@section('articles')
@can('list-role')

    <x-page-header title="Show Role" :back="route('roles.index')"></x-page-header>

    <div class="role-view">
        <div class="role-view-name">
            <strong>Name:</strong> {{ $role->name }}
        </div>

        <div class="role-view-perms">
            <strong>Permissions:</strong>
            <div class="role-view-chips">
                @forelse ($rolePermissions as $v)
                    <span class="role-view-chip">{{ ucfirst(str_replace('-', ' ', $v->name)) }}</span>
                @empty
                    <span class="role-view-empty">No permissions.</span>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .role-view { padding-top: 4px; }
        .role-view-name { font-size: 1.05rem; margin-bottom: 16px; }
        .role-view-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
        .role-view-chip {
            background: #242e42;
            border: 1px solid rgba(217, 168, 64, 0.28);
            color: #e7edf7;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 0.85rem;
        }
        .role-view-empty { opacity: 0.7; }
    </style>

@else
    <h4>You are not allowed to enter this page...</h4>
@endcan
@endsection
