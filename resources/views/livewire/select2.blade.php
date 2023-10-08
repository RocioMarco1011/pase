<!-- resources/views/livewire/select2.blade.php -->
        
        <select class="select2" multiple>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        $('.select2').select2();
    });
</script>
@endpush

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>