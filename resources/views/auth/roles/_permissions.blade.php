@php
    // Group permissions into readable sections. $selected is an array/collection
    // of permission ids that should be pre-checked (empty on the create form).
    $selected = collect($selected ?? []);

    $groups = [
        'Users' => [], 'Settings' => [], 'Projects' => [],
        'Purchases' => [], 'Roles' => [], 'Other' => [],
    ];

    foreach ($permission as $p) {
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

<div class="perm-groups">
    @foreach ($groups as $groupName => $items)
        <div class="perm-group">
            <h3>{{ $groupName }}</h3>
            @foreach ($items as $value)
                <label class="perm-item">
                    <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                        @checked($selected->contains($value->id))>
                    <span>{{ ucfirst(str_replace('-', ' ', $value->name)) }}</span>
                </label>
            @endforeach
        </div>
    @endforeach
</div>
