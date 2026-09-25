@props(['title', 'back' => null])

{{-- Shared page header bar. Place it as the FIRST child of the content
     panel (directly inside @section('articles'), before any wrapper) so it
     hugs the panel edges. Back on the left, title next, actions (slot) right. --}}
<div class="content-head">
    @if ($back)
        <a class="btn btn-warning content-head__back" href="{{ $back }}">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    @endif
    <h2 class="content-head__title">{{ $title }}</h2>
    @if (trim($slot) !== '')
        <div class="content-head__actions">{{ $slot }}</div>
    @endif
</div>
