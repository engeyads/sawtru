@props(['roles', 'selected' => []])

{{-- Reusable searchable multi-select for role assignment (Choices.js),
     themed to match the app, with Select all / Select none inside the
     dropdown panel. Used by Create/Edit User. --}}
<div class="role-select-field">
    <select name="roles[]" id="roleSelect" class="form-control" multiple>
        @foreach ($roles as $value => $label)
            <option value="{{ $value }}" @selected(in_array($value, (array) $selected))>{{ $label }}</option>
        @endforeach
    </select>
</div>

@once
    @push('custom-scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.css">
        <style>
            /* Theme Choices.js to match the app's navy/gold palette. */
            .role-select-field .choices__inner {
                background: #fff;
                color: #171616;
                border: 1px solid rgba(0,0,0,0.15);
                border-radius: var(--border-radius, 4px);
                min-height: 44px;
                padding: 6px 8px 4px;
            }
            .role-select-field .choices__list--multiple .choices__item {
                background: #242e42;
                border: 1px solid #D9A840;
                color: #f4f7fb;
                border-radius: 4px;
            }
            .role-select-field .choices__list--multiple .choices__item .choices__button {
                border-left-color: rgba(255,255,255,0.4);
                filter: none;
                opacity: 0.8;
            }
            .role-select-field .choices__input {
                background: #fff;
                color: #171616;
            }
            .role-select-field .choices__list--dropdown,
            .role-select-field .choices__list[aria-expanded] {
                background: #fff;
                border-color: rgba(0,0,0,0.15);
                max-height: 240px;
                overflow-y: auto;
            }
            .role-select-field .choices__list--dropdown .choices__item--selectable,
            .role-select-field .choices__list[aria-expanded] .choices__item--selectable {
                color: #171616;
            }
            .role-select-field .choices__list--dropdown .choices__item--selectable.is-highlighted,
            .role-select-field .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
                background: #f5e5c0;
                color: #171616;
            }

            /* Select all / Select none row, shown as the first row inside
               the dropdown panel (not floating outside the field). */
            .role-select-actions {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 10px;
                font-size: 0.82rem;
                border-bottom: 1px solid rgba(0,0,0,0.1);
                background: #f7f4ec;
            }
            .role-select-actions button {
                background: none;
                border: none;
                padding: 0;
                color: #b8860b;
                cursor: pointer;
                text-decoration: underline;
                font-size: inherit;
            }
            .role-select-actions button:hover { color: #8a6508; }
            .role-select-actions .sep { color: #999; }
        </style>
    @endpush
@endonce

@push('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.js"></script>
    <script>
        (function () {
            var el = document.getElementById('roleSelect');
            if (!el || !window.Choices) return;
            var choices = new Choices(el, {
                removeItemButton: true,
                shouldSort: false,
                placeholderValue: 'Select roles',
                searchPlaceholderValue: 'Search roles...',
            });

            // Insert a "Select all / Select none" row as the first item
            // inside the dropdown panel itself.
            var field = el.closest('.role-select-field');
            var dropdown = field.querySelector('.choices__list--dropdown');
            if (dropdown) {
                var row = document.createElement('div');
                row.className = 'role-select-actions';
                row.innerHTML = '<button type="button" data-role-action="all">Select all</button>' +
                    '<span class="sep">&middot;</span>' +
                    '<button type="button" data-role-action="none">Select none</button>';
                dropdown.insertBefore(row, dropdown.firstChild);

                row.querySelector('[data-role-action="all"]').addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    Array.from(el.options).forEach(function (o) { choices.setChoiceByValue(o.value); });
                });
                row.querySelector('[data-role-action="none"]').addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    choices.removeActiveItems();
                });
            }
        })();
    </script>
@endpush
