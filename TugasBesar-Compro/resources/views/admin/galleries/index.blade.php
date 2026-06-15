@extends('admin.layouts.app')

@section('title', 'Manajemen Galeri - Sejenak Studio')

@section('content')
<style>
    .admin-gallery-photo {
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        display: block;
    }
    #img-preview-wrap { display:none; margin-top:10px; }
    #img-preview { width:100%; max-height:200px; object-fit:cover; border-radius:10px; }
    #upload-size-info { font-size:12px; margin-top:6px; }
    #upload-spinner { display:none; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold" style="color: #007A75;">Manajemen Galeri</h3>
    <button class="btn fw-bold text-dark" style="background:#FFD000;" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
        <i class="fas fa-plus me-2"></i>Tambah Foto
    </button>
</div>

@if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif

<div class="row g-4">
    @forelse($galleries as $gallery)
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative h-100">
            <img src="{{ url('images/galleries/' . $gallery->image) }}" onerror="this.onerror=null; this.src='{{ asset('images/sejenak-logo.svg') }}'; this.style.objectFit='contain'; this.style.padding='28px';" class="admin-gallery-photo" alt="{{ $gallery->title }}">
            <div class="p-2 text-center bg-white">
                <span class="badge bg-primary mb-1">{{ $gallery->category }}</span>
            </div>
            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow" onclick="return confirm('Hapus foto ini?');"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
        <i class="fas fa-images fa-4x text-muted mb-3 opacity-25"></i>
        <p class="text-muted">Belum ada foto galeri, silakan tambah foto baru.</p>
    </div>
    @endforelse
</div>

<!-- Modal Tambah Galeri -->
<div class="modal fade" id="addGalleryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" id="gallery-upload-form">
                @csrf
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold" style="color:#007A75;">Tambah Foto Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori / Paket</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Foto</label>
                        <input type="file" name="image" id="gallery-file-input" class="form-control" accept="image/jpeg,image/jpg,image/png,image/webp" required>
                        <div id="upload-size-info" class="text-muted"></div>
                        <div id="img-preview-wrap">
                            <img id="img-preview" src="" alt="Preview">
                        </div>
                        <small class="text-muted d-block mt-1">Format: JPG, PNG, WebP. File besar akan dikompres otomatis.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold" id="upload-btn" style="background:#00A99D;">
                        <span id="upload-spinner" class="spinner-border spinner-border-sm me-1" role="status"></span>
                        <span id="upload-btn-text"><i class="fas fa-upload me-1"></i>Upload Foto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('gallery-file-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const sizeMB = (file.size / 1024 / 1024).toFixed(2);
    const info   = document.getElementById('upload-size-info');
    info.innerHTML = sizeMB > 5
        ? `<span class="text-warning"><i class="fas fa-info-circle me-1"></i>Ukuran ${sizeMB} MB — akan dikompres otomatis saat diupload.</span>`
        : `<span class="text-success"><i class="fas fa-check-circle me-1"></i>Ukuran ${sizeMB} MB — siap diupload.</span>`;

    // Preview
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('img-preview').src = e.target.result;
        document.getElementById('img-preview-wrap').style.display = 'block';
    };
    reader.readAsDataURL(file);
});

document.getElementById('gallery-upload-form').addEventListener('submit', function() {
    document.getElementById('upload-spinner').style.display = 'inline-block';
    document.getElementById('upload-btn').disabled = true;
    document.getElementById('upload-btn-text').textContent = 'Mengupload...';
});
</script>
@endsection

