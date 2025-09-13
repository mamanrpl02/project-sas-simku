<div class="flex justify-between items-center">
    <div class="kiri">
        <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/siswas' => 'Siswa',
            '' => 'List',
        ]" />

        <h1 style="font-weight: 800; font-size:1.8rem">Siswa</h1>
    </div>
    <div class="kanan">
        {{ $data }}
    </div>
</div>

<form action="{{ route('siswas.import') }}" method="POST" enctype="multipart/form-data"
    class="space-y-3 border p-4 bg-white">
    @csrf

    <div>
        <input type="file" name="file" class="border rounded p-2 w-full" required>
    </div>

    <x-filament::button type="submit" color="primary">
        Import
    </x-filament::button>
</form>
